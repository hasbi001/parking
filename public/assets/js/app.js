function durasi() {
    var masuk = $("#jam_masuk").val();
    var keluar = $("#jam_keluar").val();
    var jenis = $("#jenis_kendaraan option:selected").val();
    if(masuk){
        var durasi = Math.abs(new Date(keluar) - new Date(masuk));
        var diffMins = parseInt(durasi / (1000 * 60 * 60) % 24);
        console.log(jenis);
        $("#duration").val(diffMins);
        if (jenis == 'motor') {
            $("#tarif_parkir").val(diffMins*2000);
        }
        else
        {
            $("#tarif_parkir").val(diffMins*3000);
        }
    }
}