$(function () {
    const urlBase = "index.php";

    cargarSolicitudes();

    $(document).on("click", "#btnLogout", function () {
        $.post(urlBase, { option: "logout" }, function () {
            window.location = "index.php?page=login";
        });
    });

    function cargarSolicitudes() {
        const $tbody = $("#solicitudes-body");
        $tbody.html('<tr><td colspan="6">Cargando...</td></tr>');

        $.get(urlBase, { option: "solicitudes_json" }, function (data) {
            $tbody.empty();

            if (!data || data.length === 0) {
                $tbody.html('<tr><td colspan="6">No hay solicitudes pendientes.</td></tr>');
                return;
            }

            data.forEach(function (s) {
                const row = `
                    <tr id="fila-${s.id}">
                        <td>${s.id}</td>
                        <td>${s.taller}</td>
                        <td>${s.username}</td>
                        <td>${s.cupo_disponible}</td>
                        <td>${s.fecha_solicitud}</td>
                        <td>
                            <button class="btn btn-success btn-sm btn-aprobar" data-id="${s.id}">Aprobar</button>
                            <button class="btn btn-danger btn-sm btn-rechazar" data-id="${s.id}">Rechazar</button>
                        </td>
                    </tr>`;
                $tbody.append(row);
            });

        }).fail(function () {
            $tbody.html('<tr><td colspan="6">Error al cargar.</td></tr>');
        });
    }

    $(document).on("click", ".btn-aprobar", function () {
        const id = $(this).data("id");

        $.post(urlBase, { option: "aprobar", id_solicitud: id }, function (res) {
            if (res.success) {
                alert("Solicitud aprobada");
                $(`#fila-${id}`).remove();
            } else {
                alert(res.error || "Error al aprobar");
            }
        });
    });

    $(document).on("click", ".btn-rechazar", function () {
        const id = $(this).data("id");

        $.post(urlBase, { option: "rechazar", id_solicitud: id }, function (res) {
            if (res.success) {
                alert("Solicitud rechazada");
                $(`#fila-${id}`).remove();
            } else {
                alert(res.error || "Error al rechazar");
            }
        });
    });

});