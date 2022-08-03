@extends('layouts.app')

@section('content')
<div class="container">
    <form class="form-horizontal" id="form-parking">
        @csrf
        <input type="hidden" name="id" id="id" value="">    
        <div class='row'>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kode Tiket</label>
                    <input type="text" name="kode_tiket" id="kode_tiket" class="form-control" value='{{ $kode }}'  placeholder="kode tiket" disabled>
                </div>
                <div class="form-group">
                    <label>Jenis</label>
                    <select name="jenis_kendaraan" class="form-control" id="jenis_kendaraan">
                        <option value="motor">Motor</option>
                        <option value="mobil">Mobil</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Plat Nomor</label>
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" name="plat_no_1" id="plat_no_1" class="form-control"  required />
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="plat_no_2" id="plat_no_2" class="form-control"  required />
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="plat_no_3" id="plat_no_3" class="form-control"  required />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Jam Masuk</label>
                    <input type="text" name="jam_masuk" id="jam_masuk" class="form-control" placeholder="Jam masuk" disabled>
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <label>Jam Keluar</label>
                    <input type="text" name="jam_keluar" id="jam_keluar" class="form-control" onchange="durasi()" placeholder="Jam keluar" >
                </div>
                <div class="form-group">
                    <label>Durasi</label>
                    <input type="text" name="duration" id="duration" class="form-control" placeholder="Durasi" disabled>
                </div>
                <div class="form-group">
                    <label>Tarif</label>
                    <input type="text" name="tarif_parkir" id="tarif_parkir" class="form-control" placeholder="Tarif parkir" disabled>
                </div>
                <div class="form-group">
                    <a href="javascript:void(0)" id="submit" class="btn btn-primary">Submit</a>
                    <a href="javascript:void(0)" id="cancel" class="btn btn-danger">Cancel</a>
                    <a herf="{{ url('/export') }}" class="btn btn-info">Print PDF</a>                    
                </div>
            </div>
        </div>
    </form>
    
    <table class="table table-bordered " id="parkir-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tiket</th>
                <th>Jenis Kendaraan</th>
                <th>Plat Nomor</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Duration</th>
                <th>Tarif Parkir</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <center>
        <h4>Total {{ $total }} rows</h4>
    </center>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="alert">
      ...
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#jam_keluar').datetimepicker({
        format:"Y-m-d H:i"
    });

    var table = $('#parkir-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('list') }}",
            type: 'POST'
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_tiket', name: 'kode_tiket'},
            {data: 'jenis_kendaraan', name: 'jenis_kendaraan'},
            {data: 'plat_no', name: 'plat_no'},
            {data: 'jam_masuk', name: 'jam_masuk'},
            {data: 'jam_keluar', name: 'jam_keluar'},
            {data: 'duration', name: 'duration'},
            {data: 'tarif_parkir', name: 'tarif_parkir'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });

    $('#submit').click(function () {
        var url = "{{ url('/store') }}";
        var id = $("#id").val();
        if (id) {
            url = "{{ url('/update') }}/"+id;
        } 
       
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
           type:'POST',
           dataType : 'JSON',
           url: url,
           data : {
            id : $("#id").val(),
            kode_tiket : $("#kode_tiket").val(),
            jenis_kendaraan : $("#jenis_kendaraan").val(),
            plat_no_1 : $("#plat_no_1").val(),
            plat_no_2 : $("#plat_no_2").val(),
            plat_no_3 : $("#plat_no_3").val(),
            jam_masuk : $("#jam_masuk").val(),
            jam_keluar : $("#jam_keluar").val(),
            duration : $("#duration").val(),
            tarif_parkir : $("#tarif_parkir").val()
           },
           success:function(data){
              if (data == 'success') {
                location.reload();
              }
              else
              {
                $("#alert").html(data);
                $('.modal').modal('show');
              }
           }
           
        });
    });

    $('#cancel').click(function () {
        location.reload();
    });
  });

  function edit(id) {
        console.log(id);
        $.ajax({
           type:'GET',
           dataType : 'JSON',
           url:"{{ url('/edit') }}/"+id,
           success:function(data){
              console.log(data);
              console.log(data.kode_tiket);
              $("#id").val(data.id);
              $("#kode_tiket").val(data.kode_tiket);
              $('#jenis_kendaraan').val(data.jenis_kendaraan).attr("selected", "selected");
              $("#plat_no_1").val(data.plat_no_1);
              $("#plat_no_2").val(data.plat_no_2);
              $("#plat_no_3").val(data.plat_no_3);
              $("#jam_masuk").prop( "disabled", false );
              $("#jam_masuk").datetimepicker({
                    format:"Y-m-d H:i",
                    value:data.jam_masuk
                });
              

           }
        });
    }

   
</script>
@endsection