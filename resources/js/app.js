async function getUser() {
    const token = localStorage.getItem("token");

    const res = await fetch("/api/user", {
        headers: {
            Authorization: "Bearer " + token
        }
    });

    return await res.json();
}

getUser().then(data => console.log(data));