
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" >

</head>

  <body>


    <!-- Adding Student  -->
    <div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveStudent">
                <div class="modal-body">

                    <div id="errorMessage" class="alert alert-warning d-none"></div>

                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="text" name="email" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="">Phone</label>
                        <input type="text" name="phone" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label for="">Course</label>
                        <input type="text" name="course" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save Student</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Update Student  -->
    <div class="modal fade" id="studentUpdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStudent">
                <div class="modal-body">

                    <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>
                    
                    <input type="hidden" name="student_id" id="student_id">

                    <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label for="course">Course</label>
                        <input type="text" id="course" name="course" class="form-control" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update Student</button>
                </div>
            </form>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>
                            Students
                        </h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentAddModal">
                            Add Student
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                        include(__DIR__."/table.php");
                    ?>

                </div>
            </div>
        </div>
    </div>






<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" ></script>

<script>

    // Add student
    $(document).on('submit', '#saveStudent', function(e){
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("save_student", true);

        $.ajax({
            type: 'POST',
            url: 'code.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){

                var res = jQuery.parseJSON(response);
                if(res.status == 422){
                    $('#errorMessage').removeClass('d-none');
                    $('#errorMessage').text(res.message);
                }else if(res.status == 200){
                    $('#errorMessage').addClass('d-none');
                    $('#studentAddModal').modal('hide');
                    $('#saveStudent')[0].reset();
                    // Tabloyu güncellemek için AJAX çağrısı yapın
                    $.ajax({
                        url: 'table.php', // Tablo içeriğini barındıran dosya
                        type: 'GET',
                        success: function(response) {
                            // Yeni tabloyu içeren HTML ile tablo konteynerını güncelleyin
                            $('#myTable').html(response);
                        },
                        error: function() {
                            console.log('Tablo güncelleme hatası');
                        }
                    });
                }


            }
        })

    })

    // Get Edit Student
    $(document).on('click', ".editBtn", function(e){
        var student_id = $(this).val();

        $.ajax({
            type: 'GET',
            url: 'code.php?student_id=' + student_id,
            success: function(response){

                var res = jQuery.parseJSON(response);
                if(res.status == 422){
                    alert(res.message);
                }else if(res.status == 200){
                    $("#student_id").val(res.data.id);
                    $("#name").val(res.data.name);
                    $("#email").val(res.data.email);
                    $("#phone").val(res.data.phone);
                    $("#course").val(res.data.course);

                    $("#studentUpdateModal").modal('show');
                   
                }
            }
        })
        
    })

    //Update Student
    $(document).on('submit', '#updateStudent', function(e){
        e.preventDefault();


        var formData = new FormData(this);
        formData.append("update_student", true);

        $.ajax({
            type: 'POST',
            url: 'code.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){

                var res = jQuery.parseJSON(response);
                if(res.status == 422){
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);
                }else if(res.status == 200){
                    $('#errorMessageUpdate').addClass('d-none');
                    $('#studentAddModal').modal('hide');
                    $('#updateStudent')[0].reset();
                    // Tabloyu güncellemek için AJAX çağrısı yapın
                    $.ajax({
                        url: 'table.php', // Tablo içeriğini barındıran dosya
                        type: 'GET',
                        success: function(response) {
                            // Yeni tabloyu içeren HTML ile tablo konteynerını güncelleyin
                            $('#myTable').html(response);
                        },
                        error: function() {
                            console.log('Tablo güncelleme hatası');
                        }
                    });
                }


            }
        })

    })


    // Delete Student
    $(document).on('click', '.deleteStudentBtn', function (e) {
        e.preventDefault();

        if(confirm('Are you sure you want to delete this data?'))
        {
            var student_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "code.php",
                data: {
                    'delete_student': true,
                    'student_id': student_id
                },
                success: function (response) {
                    console.log(response)
                    var res = jQuery.parseJSON(response);
                    if(res.status == 500) {

                        alert(res.message);
                    }else{
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);

                        $.ajax({
                        url: 'table.php', // Tablo içeriğini barındıran dosya
                        type: 'GET',
                        success: function(response) {
                            // Yeni tabloyu içeren HTML ile tablo konteynerını güncelleyin
                            $('#myTable').html(response);
                        },
                        error: function() {
                            console.log('Tablo güncelleme hatası');
                        }
                    });
                }
                }
            });
        }
    });

    
</script>

</body>
</html>