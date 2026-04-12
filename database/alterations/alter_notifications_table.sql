-- 1. Ensure columns and constraints exist
IF NOT EXISTS (SELECT * FROM sys.columns 
               WHERE object_id = OBJECT_ID('notifications') 
               AND name = 'service_order_id')
BEGIN
    ALTER TABLE notifications ADD service_order_id BIGINT NULL;
END

IF NOT EXISTS (SELECT * FROM sys.foreign_keys 
               WHERE name = 'FK_notifications_order')
BEGIN
    ALTER TABLE notifications ADD CONSTRAINT FK_notifications_order 
    FOREIGN KEY (service_order_id) REFERENCES service_orders(id) 
    ON DELETE NO ACTION;
END

-- 2. Upgrade old notifications by extracting order ID from the message
-- This assumes the message format is "Your order #123 ..."
UPDATE notifications
SET service_order_id = TRY_CAST(
    SUBSTRING(
        message, 
        CHARINDEX('#', message) + 1, 
        CASE 
            WHEN CHARINDEX(' ', message, CHARINDEX('#', message)) > 0 
            THEN CHARINDEX(' ', message, CHARINDEX('#', message)) - CHARINDEX('#', message) - 1
            ELSE LEN(message) - CHARINDEX('#', message) 
        END
    ) AS BIGINT)
WHERE service_order_id IS NULL 
AND message LIKE '%order #%';