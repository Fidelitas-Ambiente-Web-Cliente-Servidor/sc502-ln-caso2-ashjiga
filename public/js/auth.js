$(function () {
    const urlBase = "index.php";

    $("#formLogin").on("submit", function (e) {
        e.preventDefault();

        const username = $("#username").val();
        const password = $("#password").val();

        if (!username || !password) {
            alert("Completa todos los campos");
            return;
        }

        $.ajax({
            url: urlBase,
            type: "POST",
            data: { username: username, password: password, option: "login" },
            dataType: "json",
            success: function (res) {
                if (res.response === "00") {
                    window.location = res.rol === "admin" ? "index.php?page=admin" : "index.php?page=talleres";
                } else {
                    alert(res.message || "Credenciales incorrectas");
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert("Error de conexión");
            }
        });
    });

    $(document).on("click", "#btnLogout", function () {
        $.post(urlBase, { option: "logout" }, function () {
            window.location = "index.php?page=login";
        });
    });

});