document.addEventListener("DOMContentLoaded", function () {
    let timerElement = document.getElementById("timer");

    function updateCountdown() {
        let eventTime = new Date("March 17, 2025 15:15:00").getTime();
        let now = new Date().getTime();
        let remainingTime = eventTime - now;

        let hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

        timerElement.innerHTML = hours + " jam " + minutes + " menit " + seconds + " detik";
    }

    setInterval(updateCountdown, 1000);

    // Form Hadir
    let form = document.getElementById("kehadiranForm");
    let list = document.getElementById("kehadiranList");

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        let nama = document.getElementById("nama").value;
        let juz = document.getElementById("juz").value;

        fetch("server.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nama, juz })
        }).then(response => response.json()).then(data => {
            alert(data.message);
            loadKehadiran();
        });
    });

    function loadKehadiran() {
        fetch("data.json").then(res => res.json()).then(data => {
            list.innerHTML = "";
            data.forEach((item) => {
                list.innerHTML += `<tr><td>${item.nama}</td><td>Juz ${item.juz}</td></tr>`;
            });
        });
    }

    document.getElementById("resetButton").addEventListener("click", function () {
        let password = prompt("Masukkan Password untuk Reset:");
        if (password === "taqri123") {
            fetch("server.php?reset=true", { method: "GET" }).then(() => loadKehadiran());
        } else {
            alert("Password salah!");
        }
    });

    loadKehadiran();
});
