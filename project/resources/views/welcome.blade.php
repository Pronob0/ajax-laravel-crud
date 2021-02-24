<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Hello, world!</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="{{asset('assets/bootstrap.min.css')}}" >
    <link rel="stylesheet" href="{{asset('assets/toastr.min.css')}}">

    <script src="{{asset('assets/jquery.min.js')}}"></script>

    <script src="{{asset('assets/popper.min.js')}}" ></script>
    <script src="{{asset('assets/bootstrap.min.js')}}" ></script>



  </head>
  <body>

    <div class="container">
        <input type="hidden" id="headerdata" value="{{ __('CATEGORY') }}">
        <button id="add-btn" type="button" class="btn btn-danger mt-5" data-toggle="modal" data-target="#studentmodal">Add New</button>

        <table class="table mt-5">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Action</th>
                {{-- <th scope="col">Action</th> --}}
              </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td scope="row">{{$student->id}}</td>
                    <td>{{$student->firstname}}</td>
                    <td>{{ $student->lastname }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone }}</td>
                    <td><a id="edit-btn" class="btn btn-warning btn-sm">edit</a> || <a class="btn btn-danger btn-sm" id="delete-btn">delete</a></td>
                  </tr>

                @endforeach


            </tbody>
          </table>
    </div>
<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="studentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <div class="modal-body">
            @include('includes.admin.form-error')
        <form id="studentForm" method="POST">
         @csrf
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" value="" name="firstname" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <button id="submit-btn" type="submit" class="btn btn-success">submit</button>
        </form>
        </div>

      </div>
    </div>
  </div>
  <!-- Edit Modal -->

  <div class="modal fade" id="studentmodal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <div class="modal-body">
            @include('includes.admin.form-error')
        <form id="studentForm2" >
         @csrf


         <input type="hidden" id="id" name="id">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" value="" id="firstname" name="firstname" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" class="form-control">
            </div>
            <button id="submit-btn" type="submit" class="btn btn-success">submit</button>
        </form>
        </div>

      </div>
    </div>
  </div>

  {{-- Delete Modal --}}


  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="delete-data">
            @csrf
            @method('delete')
        <div class="modal-body">


            <input type="text" name="delete_id" id="delete_id">

                     Are You sure to delete this Data?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="confirm-delete" class="btn btn-danger">Delete</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  {{-- delete modal end --}}



  <script src="{{asset('assets/toastr.min.js')}}"></script>
  {!! Toastr::message() !!}





  <script>
      $(document).on('submit','#studentForm',function(e){
        e.preventDefault();

      let fd = new FormData(this);
      var $this = $(this).parent();


    $.ajax({
           url: "{{route('store')}}",
           type: "POST",
            data: fd,
            processData: false,
            contentType:false,
           success: function(success)
           {
               if(success.errors){

                                $this.find('.alert-danger').show();
                                $this.find('.alert-danger ul').html('');
                                for (var error in success.errors) {
                                $this.find('.alert-danger ul').append('<li>' + success.errors[error] + '</li>');
                                }
                                $("#studentmodal .modal-content .modal-body .alert-danger").focus();
                                $('#submit-btn').prop('disabled', false);
                                $('#studentForm input').eq(1).focus();


            }
               else{

                    toastr.success('Data Added Successfully','Success');

                    $('#studentmodal').modal('toggle');
                    $('#submit-btn').prop('disabled',false);
                    $("#studentForm")[0].reset();

                    setTimeout(function () { location.reload(1); }, 1000);

               }





           }

         });
      });

//Edit modal form
      $(document).on('click','#edit-btn',function(){
        $('#studentmodal2').modal('show');

        $tr=$(this).closest('tr');
        var data=$tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#id').val(data[0]);
        $('#firstname').val(data[1]);
        $('#lastname').val(data[2]);
        $('#email').val(data[3]);
        $('#phone').val(data[4]);


    });
    $(document).on('submit','#studentForm2',function(e){
        e.preventDefault();

      let fd = new FormData(this);
      var $this = $(this).parent();
      var id= $('#id').val();

    $.ajax({
           url: "{{ url('/') }}/update/"+id,
           type: "POST",
            data: fd,
            processData: false,
            contentType:false,
           success: function(success)
           {
               if(success.errors){

                                $this.find('.alert-danger').show();
                                $this.find('.alert-danger ul').html('');
                                for (var error in success.errors) {
                                $this.find('.alert-danger ul').append('<li>' + success.errors[error] + '</li>');
                                }
                                $("#studentmodal2 .modal-content .modal-body .alert-danger").focus();
                                $('#submit-btn').prop('disabled', false);
                                $('#studentForm2 input').eq(1).focus();


            }
               else{

                    toastr.success('Data Added Successfully','Success');

                    $('#studentmodal2').modal('toggle');
                    $('#submit-btn').prop('disabled',false);
                    $("#studentForm2")[0].reset();

                    setTimeout(function () { location.reload(1); }, 1000);

               }





           }

         });
      });

// delete

$(document).on('click','#delete-btn',function(){
    $('#deleteModal').modal('show');

    $tr=$(this).closest('tr');
        var data=$tr.children('td').map(function(){
            return $(this).text();
        }).get();

        console.log(data);

        $('#delete_id').val(data[0]);


});

$(document).on('submit','#delete-data',function(e){
e.preventDefault();

var id=$('#delete_id').val();


      $.ajax({

          url:"{{ url('/') }}/delete/"+id,
          type:'GET',
          datatType:'JSON',
          data:$("#delete-data").serialize(),

           success:function(success){
            toastr.success('Data Deleted Successfully','Success');

             $('#deleteModal').modal('toggle');

            setTimeout(function () { location.reload(1); }, 1000);
          }

      });

});

  </script>
<script>





</script>
  </body>
</html>
