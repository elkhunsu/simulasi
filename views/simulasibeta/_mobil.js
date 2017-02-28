$('#mobil-form').on("submit", function (e) {

    var formData = {
        harga: $("#harga").val(),
        tahun: $("#tahun").val(),
        tenor: $("#tenor").val(),
        funding: $("#funding").val(),
    };
    var formURL = '<?php echo Yii::$app->request->baseUrl . '/simulasibeta/hitung' ?>';
            $.ajax(
                    {
                        url: formURL,
                        type: "POST",
                        data: formData,
//                        contentType: false,
//                        processData: false,
                        success: function (data, textStatus, jqXHR)
                        {
//                    window.location = "{$urlIndex}";
                            $("#angsuran").val(data.data);
                            console.log(data.data);
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert("gagal");
                        }
                    });
    e.preventDefault();
    e.unbind(); //untuk mencegah berkali kali submit
});