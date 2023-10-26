$(document).ready(function () {
  function loadKetentuanData() {
    $.ajax({
      url: "ajax/fasilitas.php?action=loadUmum",
      type: "GET",
      dataType: "json",
      success: function (data) {
        var html = "";
        for (var i = 0; i < data.length; i++) {
          html += "<div class='form-check'>";
          html +=
            "<input class='form-check-input' type='checkbox' value='" +
            data[i].id +
            "' id='rule" +
            data[i].id +
            "' name='rule[]'>";
          html +=
            "<label class='form-check-label' for='rule" +
            data[i].id +
            "'>" +
            data[i].description +
            "</label>";
          html += "</div>";
        }
        $("#room_rule").html(html);
      },
    });
  }
  loadKetentuanData();
  function loadFasilitasData() {
    $.ajax({
      url: "ajax/fasilitas.php?action=loadUmum",
      type: "GET",
      dataType: "json",
      success: function (data) {
        html = "";
        for (var i = 0; i < data.length; i++) {
          html += "<tr>";
          html += "<td>" + (i + 1) + "</td>";
          html +=
            "<td class='w-25'> <img class='rounded img-thumbnail' src='./../assets/images/facility/" +
            data[i].picture +
            "' width='124' height='124'></td>";
          html += "<td>" + data[i].name + "</td>";
          html += "<td>" + data[i].description + "</td>";
          html +=
            "<td> <button type='button' data-bs-toggle='modal' data-bs-target='#staticBackdropFasilitasEdit' class='btn btn-primary me-2' data-id='" +
            data[i].id +
            "' data-name='" +
            data[i].name +
            "' data-description='" +
            data[i].description +
            "' data-picture='" +
            data[i].picture +
            "'>Edit</button><button type='button' data-bs-toggle='modal' data-bs-target='#staticBackdropFasilitasHapus' class='btn btn-danger' data-id='" +
            data[i].id +
            "' data-name='" +
            data[i].name +
            "' data-description='" +
            data[i].description +
            "'>Delete</button></td>";
          html += "</tr>";
        }
        $("#fasilitasTable").html(html);
      },
    });
  }
  loadFasilitasData();
  $(document).on(
    "click",
    "button[data-bs-target='#staticBackdropFasilitasEdit']",
    function () {
      var name = $(this).data("name");
      var description = $(this).data("description");
      var images = $(this).data("picture");
      var id = $(this).data("id");

      $("#edit_nama").val(name);
      $("#edit_description").val(description);
      $("#edit_id").val(id);
      $("#edit_image").val(images);
    }
  );
  $(document).on(
    "click",
    "button[data-bs-target='#staticBackdropFasilitasHapus']",
    function () {
      var name = $(this).data("name");
      var id = $(this).data("id");
      $("#hapus_id").val(id);
      $("#hapus_nama").text(name);
    }
  );
  $("#tambahFasilitasUmum").on("submit", function (e) {
    var formData = new FormData(this);
    e.preventDefault();
    $.ajax({
      url: "ajax/fasilitas.php?action=tambahFasilitasUmum",
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        $("#tambahFasilitasUmum")[0].reset();
        loadFasilitasData();
      },
    });
  });
  $("#editFasilitasUmum").on("submit", function (e) {
    var formData = new FormData(this);
    e.preventDefault();
    $.ajax({
      url: "ajax/fasilitas.php?action=editFasilitasUmum",
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        $("#editFasilitasUmum")[0].reset();
        loadFasilitasData();
      },
    });
  });
  $("#hapusFasilitasUmum").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "ajax/fasilitas.php?action=hapusFasilitasUmum",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        loadFasilitasData();
      },
    });
  });
});
