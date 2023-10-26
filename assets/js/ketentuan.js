$(document).ready(function () {
  function loadUmumKetentuanData() {
    $.ajax({
      url: "ajax/ketentuan.php?action=loadUmum",
      type: "GET",
      dataType: "json",
      success: function (data) {
        var html = "";
        for (i = 0; i < data.length; i++) {
          html += "<tr >";
          html += "<td>" + (i + 1) + "</td>";
          html += "<td class='w-75'>" + data[i].description + "</td>";
          html +=
            "<td><button type='button' data-bs-toggle='modal' data-bs-target='#staticBackdropUmumEdit' class='btn btn-primary me-2' data-id='" +
            data[i].id +
            "' data-isGeneral='" +
            data[i].isGeneral +
            "' data-description='" +
            data[i].description +
            "'>Edit</button><button type='button' data-bs-toggle='modal' data-bs-target='#staticBackdropUmumHapus' class='btn btn-danger' data-id='" +
            data[i].id +
            "' data-description='" +
            data[i].description +
            "'>Delete</button></td>";
          html += "</tr>";
        }
        $("#ketentuanTable").html(html);
      },
    });
  }
  function loadKamarKetentuanData() {
    $.ajax({
      url: "ajax/ketentuan.php?action=loadKamar",
      type: "GET",
      dataType: "json",
      success: function (data) {},
    });
  }
  loadKamarKetentuanData();
  loadUmumKetentuanData();
  $(document).on(
    "click",
    "button[data-bs-target='#staticBackdropUmumEdit']",
    function () {
      var description = $(this).data("description");
      var id = $(this).data("id");

      $("#edit_description").val(description);
      $("#edit_id").val(id);
    }
  );
  $(document).on(
    "click",
    "button[data-bs-target='#staticBackdropUmumHapus']",
    function () {
      var description = $(this).data("description");
      var id = $(this).data("id");
      $("#hapus_id").val(id);
      $("#hapus_description").text(description);
    }
  );
  $("#tambahKetentuanUmum").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "ajax/ketentuan.php?action=tambahUmum",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        loadUmumKetentuanData();
        $("#tambahKetentuanUmum")[0].reset();
      },
    });
  });
  $("#editKetentuanUmum").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "ajax/ketentuan.php?action=editUmum",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        loadUmumKetentuanData();
      },
    });
  });
  $("#hapusKetentuanUmum").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "ajax/ketentuan.php?action=hapusUmum",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        loadUmumKetentuanData();
      },
    });
  });
});
