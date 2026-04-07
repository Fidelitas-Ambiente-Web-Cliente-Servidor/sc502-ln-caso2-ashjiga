$(function () {
    const urlBase = "index.php";

    $("#formRegister").on("submit", function (e) {
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
            data: { username: username, password: password, option: "register" },
            dataType: "json",
            success: function (res) {
                if (res.response === "00") {
                    alert("Usuario creado correctamente");
                    window.location.href = "index.php?page=login";
                } else {
                    alert(res.message || "Error al registrar");
                }
            },
            error: function () {
                alert("Error de conexión");
            }
        });
    });
});