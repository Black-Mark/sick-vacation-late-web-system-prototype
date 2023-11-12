<?php
include("../../constants/routes.php");
// include($components_file_error_handler);
include($constants_file_dbconnect);
include($constants_file_session_admin);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Human Resources of Municipality of Indang - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HR - Indang Municipality Admin Page">
    <?php
    include($constants_file_html_credits);
    ?>
    <link rel="icon" type="image/x-icon" href="../../assets/images/indang-logo.ico">

    <link rel="stylesheet" href="../../assets/bootstrap/dist/css/bootstrap.min.css">
    <script src="../../assets/bootstrap/assets/js/vendor/jquery-slim.min.js"></script>
    <script src="../../assets/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="../../assets/bootstrap/dist/js/bootstrap.min.js"></script>

    <link rel='stylesheet' href='../../assets/font-awesome/css/font-awesome.min.css'>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- <script src="../assets/js/tailwind.js"></script> -->




    <link href="./extra/bootstrap.min.css" rel="stylesheet">
    <link href="./extra/bootstrap-responsive.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./extra/jquery-ui-1.10.3.full.min.css">
    <link rel="stylesheet" href="./extra/font-awesome.min.css">
    <link rel="stylesheet" href="./extra/font-awesome.min2.css">

    <!--[if IE 7]>
          <link rel="stylesheet" href='https://registrar.cvsu.edu.ph/assets/css/font-awesome-ie7.min.css' />
        <![endif]-->

    <link rel="stylesheet" href="./extra/ace-fonts.css">

    <!-- ace styles -->
    <link rel="stylesheet" href="./extra/ace.min.css">
    <link rel="stylesheet" href="./extra/ace-rtl.min.css">
    <link rel="stylesheet" href="./extra/ace-responsive.min.css">
    <link rel="stylesheet" href="./extra/ace-skins.min.css">

    <link rel="stylesheet" type="text/css" href="./extra/dd.css">
    <link rel="stylesheet" type="text/css" href="./extra/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./extra/buttons.dataTables.min.css">


</head>

<body class="webpage-background-cover-admin">
    <div>
        <?php include($components_file_topnav) ?>
    </div>

    <div class="page-container">
        <div class="page-content">
            <div class="text-experiment">This is Departments</div>

            <!-- Button trigger modal -->
            <div>
                <button type="button" class="custom-regular-button" data-toggle="modal" data-target="#addEmployee">
                    Add Employee
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput"
                                        placeholder="name@example.com">
                                    <label for="floatingInput">Email address</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="floatingPassword"
                                        placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span12">
                    <!--PAGE CONTENT BEGINS-->

                    <div class="space-6"></div>

                    <div class="hr hr-18 dotted hr-double"></div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="table-header header-color-green2">
                                List of Students
                            </div>
                            <div id="dtstudent_wrapper" class="dataTables_wrapper no-footer">
                                <table id="dtstudent"
                                    class="table table-striped table-bordered table-hover dataTable no-footer"
                                    width="100%" cellspacing="0" role="grid" aria-describedby="dtstudent_info"
                                    style="width: 100%;">
                                    <thead>
                                        <tr class="table-header" role="row">
                                            <th class="sorting_asc" rowspan="1" colspan="1" data-column-index="0"
                                                aria-label="#" style="width: 13px;">#</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" data-column-index="1"
                                                aria-label="Student Name" style="width: 68px;">Student Name</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" data-column-index="2"
                                                aria-label="Student Number" style="width: 61px;">Student Number</th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" data-column-index="3"
                                                aria-label="Course" style="width: 47px;">Course</th>
                                            <th class="sorting" tabindex="0" aria-controls="dtstudent" rowspan="1"
                                                colspan="1" data-column-index="4"
                                                aria-label="Sex: activate to sort column ascending"
                                                style="width: 33px;">Sex</th>
                                            <th class="sorting" tabindex="0" aria-controls="dtstudent" rowspan="1"
                                                colspan="1" data-column-index="5"
                                                aria-label="Status: activate to sort column ascending"
                                                style="width: 43px;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">1</td>
                                            <td>ASOR, EMMANUEL M.</td>
                                            <td>202011238</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">2</td>
                                            <td>AUSTRIA , LIN MOIRA M.</td>
                                            <td>202013494</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">3</td>
                                            <td>AYOS, JUNUEL KEITH M.</td>
                                            <td>202011275</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">4</td>
                                            <td>BABLES, MARINEL C.</td>
                                            <td>202013765</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">5</td>
                                            <td>BAMBA, MICKY ELAINE O.</td>
                                            <td>202013969</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">6</td>
                                            <td>BEIGHTOL, JAN LORENZE</td>
                                            <td>202013148</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">7</td>
                                            <td>BELTRAN, GLYDEL O.</td>
                                            <td>202012367</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">8</td>
                                            <td>BUIZON, RHEALYN R.</td>
                                            <td>202014553</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">9</td>
                                            <td>CREENCIA, AARON LHUEL D.</td>
                                            <td>201911320</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">10</td>
                                            <td>DIMAILIG, KYLE JANUS D.</td>
                                            <td>202012647</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">11</td>
                                            <td>ENDOZO, MARY JOY P.</td>
                                            <td>202012104</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">12</td>
                                            <td>EQUIZA, MARIA ANZEL S.</td>
                                            <td>202011160</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">13</td>
                                            <td>ESPIRITU, MARK JOHN S.</td>
                                            <td>202014012</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">14</td>
                                            <td>FULLENTE, SHANE CRISTINE C.</td>
                                            <td>202014806</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">15</td>
                                            <td>GEROCA, JESABEL A.</td>
                                            <td>202012782</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">16</td>
                                            <td>HERMOSO, SHANE D.</td>
                                            <td>202014811</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">17</td>
                                            <td>ISUGA, MARIELLE E.</td>
                                            <td>201915346</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">18</td>
                                            <td>LUCERO, COLIN JUDE M.</td>
                                            <td>202013577</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">19</td>
                                            <td>MANALO, KARL ALLEN D.</td>
                                            <td>202013165</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">20</td>
                                            <td>MEMIJE, MERVIN JAY C.</td>
                                            <td>202013940</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">21</td>
                                            <td>MENDOZA, PRANCESS ALTHEA E.</td>
                                            <td>202010970</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">22</td>
                                            <td>PULIDO, CHRISTIAN JAY L.</td>
                                            <td>202011605</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">23</td>
                                            <td>ROBEL, DIVINE JOYCE A.</td>
                                            <td>202011971</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">24</td>
                                            <td>RODRIGUEZ, JAYMARK K.</td>
                                            <td>202012674</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">25</td>
                                            <td>ROMEROSO, MARK DAVID A.</td>
                                            <td>202014646</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">26</td>
                                            <td>SALLUTAN, ETHAN GABRIEL N.</td>
                                            <td>202012269</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">27</td>
                                            <td>SORIA, ANTHONY MICHAEL C.</td>
                                            <td>202011003</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black even" role="row">
                                            <td class="sorting_1">28</td>
                                            <td>SUBIATE, LOUIS MATTHEW D.</td>
                                            <td>202013556</td>
                                            <td>BAE</td>
                                            <td>MALE</td>
                                            <td>Validated</td>
                                        </tr>
                                        <tr class="black odd" role="row">
                                            <td class="sorting_1">29</td>
                                            <td>VICEDO, PRINCESS SHEENA MAE P.</td>
                                            <td>202014369</td>
                                            <td>BAE</td>
                                            <td>FEMALE</td>
                                            <td>Validated</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>


                        </div><!--/span-->
                    </div><!--/row-->

                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!--/.span-->
            </div><!--/.row-fluid-->

        </div>
    </div>

    <!-- <div>
        <?php
        // include($components_file_footer)
        ?>
    </div> -->

    <script src="./extra/ace-extra.min.js"></script>
    <script src="./extra/jquery-1.10.2.min.js"></script>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='https://registrar.cvsu.edu.ph/assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
    </script>

    <script type="text/javascript">
        if ("ontouchend" in document) document.write("<script src='https://registrar.cvsu.edu.ph/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>

    <script src="./extra/bootstrap.min.js"></script>
    <script src="./extra/jquery-ui-1.10.3.full.min.js"></script>

    <script src="./extra/ace-elements.min.js"></script>
    <script src="./extra/ace.min.js"></script>

    <script src="./extra/jquery.dd.js"></script>

    <script type="text/javascript" src="./extra/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./extra/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="./extra/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="./extra/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="./extra/buttons.flash.min.js"></script>
    <script type="text/javascript" src="./extra/jszip.min.js"></script>
    <script type="text/javascript" src="./extra/pdfmake.min.js"></script>
    <script type="text/javascript" src="./extra/vfs_fonts.js"></script>
    <script type="text/javascript" src="./extra/buttons.html5.min.js"></script>
    <script type="text/javascript" src="./extra/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#dtstudent').DataTable({
                "bProcessing": true,
                "dom": 'Blfrti',
                'iDisplayLength': -1,
                "lengthMenu": [[20, 25, 50, 100, -1], [20, 25, 50, 100, "All"]],
                "colReorder": true,
                "buttons": [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'List of Students for 202313855-AEAP 126 - RUMINANT PRODUCTION AND MANAGEMENT',
                        exportOptions: {
                            columns: ':visible'
                        }

                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'List of Students for 202313855-AEAP 126 - RUMINANT PRODUCTION AND MANAGEMENT',
                        message: 'PDF created by CEIT-DIT',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'List of Students for 202313855-AEAP 126 - RUMINANT PRODUCTION AND MANAGEMENT',
                        message: 'This print was produced by CEIT-DIT',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        "extend": "colvis",
                        text: '<i class="fa fa-eye-slash"></i>',
                        columns: ':first,:gt(1),:last'
                    }
                ],
                "columnDefs": [{
                    "targets": [0, 1, 2, 3],
                    "orderable": false,
                }],
            });

            $("select").msDropdown({ roundedBorder: false });
            createByJson();

        })
    </script>
</body>

</html>