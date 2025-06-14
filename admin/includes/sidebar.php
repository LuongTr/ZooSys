<?php
$role = $_SESSION['role'];
?>
   <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <p style="color: white; font-size:26px;">ZMS ADMIN</p>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active">
                                <a href="dashboard.php" aria-expanded="true"><i class="ti-dashboard"></i><span>Dashboard</span></a>                              
                            </li>
                            <?php if($role == 'admin') { ?>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Employees</span></a>
                                    <ul class="collapse">
                                        <li><a href="add-employee.php">Add Employee</a></li>
                                        <li><a href="manage-employees.php">Manage Employees</a></li>
                                        <li><a href="employees-search.php">Search Employees</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Animals Details</span></a>
                                    <ul class="collapse">
                                        <li><a href="add-animals.php">Add Animals</a></li>
                                        <li><a href="manage-animals.php">Manage Animals</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Ticket</span></a>
                                    <ul class="collapse">
                                        <li><a href="add-normal-ticket.php">Add Ticket</a></li>
                                        <li><a href="manage-normal-ticket.php">Manage Ticket</a></li>
                                        <li><a href="normal-search.php">Ticket Search</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Page</span></a>
                                    <ul class="collapse">
                                        <li><a href="aboutus.php">About Us</a></li>
                                        <li><a href="contactus.php">Contact Us</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <li><a href="between-dates-normalreports.php" aria-expanded="true"><i class="ti-folder"></i><span>Report</span></a></li>
                                </li>
                            <?php } else if($role == 'animal_staff') { ?>
                                <!-- <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Employees</span></a>
                                    <ul class="collapse">
                                        <li><a href="add-employee.php">Add Employee</a></li>
                                        <li><a href="manage-employees.php">Manage Employees</a></li>
                                        <li><a href="employees-search.php">Search Employees</a></li>
                                    </ul>
                                </li> -->
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Animals Details</span></a>
                                    <ul class="collapse">
                                        <li><a href="add-animals.php">Add Animals</a></li>
                                        <li><a href="manage-animals.php">Manage Animals</a></li>
                                    </ul>
                                </li>
                                <li>
    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Cage Management</span></a>
                                    <ul class="collapse">
        <li><a href="add-cage.php">Add Cage</a></li>
        <li><a href="manage-cage.php">Manage Cage</a></li>
    </ul>
</li>

     

                                                         <!-- <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Ticket</span></a>
                                    <ul class="collapse">
                                        <li><a href="add-normal-ticket.php">Add Ticket</a></li>
                                        <li><a href="manage-normal-ticket.php">Manage Ticket</a></li>
                                        <li><a href="normal-search.php">Ticket Search</a></li>
                                    </ul>
                                </li> -->
                                <!-- <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Page</span></a>
                                    <ul class="collapse">
                                        <li><a href="aboutus.php">About Us</a></li>
                                        <li><a href="contactus.php">Contact Us</a></li>
                                    </ul>
                                </li> -->
                                <!-- <li>
                                    <li><a href="between-dates-normalreports.php" aria-expanded="true"><i class="ti-folder"></i><span>Report</span></a></li>
                                </li> -->
                            <?php } else if ($role == 'ticket_staff') { ?>
                                <li>
                                    <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Ticket</span></a>
                                    <ul class="collapse">
                                        <li><a href="add-normal-ticket.php">Add Ticket</a></li>
                                        <li><a href="manage-normal-ticket.php">Manage Ticket</a></li>
                                        <li><a href="normal-search.php">Ticket Search</a></li>
                                    </ul>
                                </li>
                            <?php }else if ($role == 'veterinary_staff') { ?>
    <li>
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Health</span></a>
        <ul class="collapse">
            <li><a href="add-health.php">Add Health</a></li>
            <li><a href="manage-health.php">Manage Health</a></li>
        </ul>
    </li>
<?php }else if ($role == 'maintenance_staff') { ?>
    <li>
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-folder"></i><span>Tree</span></a>
        <ul class="collapse">
            <li><a href="add-tree.php">Add Tree</a></li>
            <li><a href="manage-tree.php">Manage Tree</a></li>
        </ul>
    </li>
    <li>
        <a href="manage-maintenance.php"><i class="ti-settings"></i><span>Manage Maintenance</span></a>
    </li>
<?php }
 ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>