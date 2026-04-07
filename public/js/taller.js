$(function () {
    const urlBase = "index.php";

    cargarTalleres();

    $(document).on("click", "#btnLogout", function () {
        $.post(urlBase, { option: "logout" }, function () {
            window.location = "index.php?page=login";
        });
    });

    function cargarTalleres() {
        const $container = $("#talleres-container");
        $container.html('<p>Cargando talleres...</p>');

        $.get(urlBase, { option: "talleres_json" }, function (data) {
            $container.empty();

            if (!data || data.length === 0) {
                $container.html('<p>No hay talleres disponibles.</p>');
                return;
            }

            data.forEach(function (t) {
                const card = `
                    <div class="taller-card">
                        <h3>${t.nombre}</h3>
                        <p>${t.descripcion}</p>
                        <div class="taller-card-footer">
                            <span class="cupo">${t.cupo_disponible} cupo(s)</span>
                            <button class="btn btn-primary btn-sm btn-solicitar" data-id="${t.id}">Solicitar</button>
                        </div>
                    </div>`;
                $container.append(card);
            });

        }).fail(function () {
            $container.html('<p>Error al cargar talleres.</p>');
        });
    }

    $(document).on("click", ".btn-solicitar", function () {
        const tallerId = $(this).data("id");
        const $btn = $(this);

        $.post(urlBase, { option: "solicitar", taller_id: tallerId }, function (res) {
            if (res.success) {
                alert(res.message);
                $btn.prop("disabled", true).text("Solicitado");
            } else {
                alert(res.error || "Error al solicitar");
            }
        }).fail(function () {
            alert("Error de conexión");
        });
    });

});