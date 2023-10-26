$("#form_pembayaran").on("submit", function (e) {
  e.preventDefault();
  var dana_number = "0857 2003 4203 1980";
  var bank_number = "1234567890";
  var html = "";
  $.ajax({
    url: "admin/ajax/payment.php?action=pembayaran",
    type: "POST",
    data: $(this).serialize(),
    caches: false,
    success: function (response) {
      var data = JSON.parse(response);
      var type_bundling = "room";
      if (data.status == "success") {
        if (data.room.type.lenqth > 0) {
          type_bundling = data.room.type;
        } else {
          type_bundling = "room";
        }

        html += `<form action="admin/ajax/payment.php?action=konfirmasi" method="POST">`;
        html += `<h5>Nama: ${data.user.name}</h5>`;
        html += `<h5>Email: ${data.user.email}</h5>`;
        html += `<h5>Phone: ${data.user.phone}</h5>`;
        html += `<h5>Nama Kamar: ${data.room.name}</h5>`;
        html +=
          '<h5>Nomor Kamar: <span class="text-primary">' +
          data.room.id +
          "</span></h5>";
        if (data.room.type.lenqth > 0) {
          type_bundling = data.room.type;
          html += `<h5>Jenis Kamar: ${data.room.type}</h5>`;
        } else {
          type_bundling = "room";
        }
        if (data.payment == "dana") {
          html += `<h5>Nomor Rekening: <span class="text-primary">${dana_number}</span></h5>`;
        } else {
          html += `<h5>Nomor Rekening: <span class="text-primary">${bank_number}</span></h5>`;
        }
        html +=
          '<h5>Metode Pembayaran: <span class="text-primary">' +
          data.payment.toUpperCase() +
          "</span></h5>";
        html += `<h5>Total Pembayaran:<span class="text-danger"> Rp. ${data.total_price}</span> </h5>`;
        html += `<h5>Check In: <span class="text-primary">${data.check_in}</span></h5>`;
        html += `<h5>Check Out: <span class="text-primary">${data.check_out}</span></h5>`;
        html += `<button type="submit" class="btn btn-primary">Konfirmasi</button>`;
        // hidden input
        html += `<input type="hidden" name    ="type_bundling" value="${type_bundling}">`;
        html += `<input type="hidden" name    ="user_id" value="${data.user.id}">`;
        html += `<input type="hidden" name    ="room_id" value="${data.room.id}">`;
        html += `<input type="hidden" name    ="payment" value="${data.payment}">`;
        html += `<input type="hidden" name    ="total_price" value="${data.total_price}">`;
        html += `<input type="hidden" name    ="check_in" value="${data.check_in}">`;
        html += `<input type="hidden" name    ="check_out" value="${data.check_out}">`;
        html += `</form>`;
      } else {
        html += `<h3>${data.message}</hh3`;
      }
      $("#formModalPaymey").html(html);
    },
  });
});
