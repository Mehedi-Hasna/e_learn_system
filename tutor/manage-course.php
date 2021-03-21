<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 3/21/2021
 * Time: 7:27 PM
 */
?>

<?php include "front/header.php"; ?>

<body id="page-top">

<?php include "front/nav.php";?>



<div id="wrapper">
    <?php include "front/sidebar.php";?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Manage Course's</li>
            </ol>

            <!-- Icon Cards-->
            <div class="row">
                <div class="col-md-12 col-sm-12 mt-2 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h3>Manage Course's <a class="btn btn-info float-right" href="add-course.php"><i class="fa fa-plus"></i> Add New Course</a></h3>
                        </div>
                        <div class="card-body">
                            <h3 class="p-2">
                                <?php
                                if(isset($_SESSION['success'])){
                                    echo "
                                        <span class='text-success'>".$_SESSION['success']."</span>
                                     ";
                                    unset($_SESSION['success']);
                                }
                                ?>
                            </h3>

                            <div class="table-responsive">
                                <table id="bootstrap-data-table" class="text-center table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Course Status</th>
                                        <th>Course Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //get all courses
                                    $sql_get_course = $connect->query("SELECT * FROM courses WHERE user_id = '$user_data[user_id]'");

                                    $i = 1;

                                    while ($row = mysqli_fetch_assoc($sql_get_course)){?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row['course_name']?></td>
                                            <td>
                                                <?php
                                                $status = $row['course_status'];
                                                // echo $status;

                                                if (($status) == '0'){?>
                                                        <button class="btn btn-primary">Free</button>
                                                    <?php
                                                }
                                                if (($status) == '1'){?>
                                                    <button class="btn btn-info">Paid</button>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($row['course_status'] == '1') {

                                                        if ($row['course_price'] == true){
                                                            echo number_format($row['course_price'],2);

                                                        }else{?>
                                                            <a href='#description' data-toggle='modal' class='btn btn-success btn-flat desc' data-id='<?php echo $row['course_id'];?>'><i class='fa fa-plus'></i> Add Course Fee</a>
                                                        <?php }

                                                    }else{
                                                        echo "<span class='text-success'>Free Course</span>";
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-info" href="edit_course.php?course=<?php echo $row['course_id'];?>"><i class="fa fa-edit"></i> Edit</a> |
                                                <a class="btn btn-danger" href="delete.php?course=<?php echo $row['course_id'];?>"><i class="fa fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <?php include "front/sub_footer.php";?>
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->


<?php include "front/footer.php";?>
<!--edit-->


</body>
</html>
<!-- Description -->

<div class="modal fade" id="description" tabindex="-1" role="dialog" aria-labelledby="formModal"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal"> Add Course Price</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form action="add_course_price.php" method="post">
                   <div class="form-group">
                       <input type="hidden" class="course_id" name="course_id">
                       <label class="font-weight-bold">Course Fee</label>
                       <input type="text" class="form-control" placeholder="Enter Course Fee" name="course_price" id="course_price">
                   </div>
                   <div class="form-group">
                       <div class="input-group">
                           <label class="p-2"></label>
                           <button type="submit" class="btn btn-primary btn-flat btn-block" name="add_price"><i class="fa fa-save"></i> Add Course Fee</button>
                       </div>
                   </div>
               </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('click', '.desc', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        getRow(id);
    });

    function getRow(id){
        $.ajax({
            type: 'POST',
            url: 'add_course_price.php',
            data: {course_id:id},
            dataType: 'json',
            success: function(response){
                $('.course_id').val(response.course_id);
                $('#course_price').html(response.course_price);

            }
        });
    }
</script>
