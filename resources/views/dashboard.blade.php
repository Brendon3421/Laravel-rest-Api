<!DOCTYPE html>
<html lang="pt-br">

<head>
    @include('component.head')
    <title>Dashboard</title>
    <!-- Include Google Fonts and Font Awesome -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset CSS for the body */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styles */
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #2c3e50;
            color: #fff;
            transition: all 0.3s;
            position: fixed;
            height: 100%;
        }

        #sidebar .sidebar-header {
            background: #1abc9c;
            padding: 20px;
            text-align: center;
        }

        #sidebar .sidebar-header h3 {
            margin: 0;
            color: #fff;
        }

        #sidebar .components {
            padding: 20px 0;
        }

        #sidebar .components li {
            padding: 10px 15px;
        }

        #sidebar .components li a {
            color: #bdc3c7;
            font-size: 1.1em;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }

        #sidebar .components li a:hover,
        #sidebar .components li.active > a {
            color: #2c3e50;
            background: #ecf0f1;
            border: 2px solid #ffffff;
            font-weight: bold;
        }

        /* Main Content Styles */
        #content {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar {
            margin-bottom: 20px;
        }

        .topbar {
            background: #fff;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link {
            color: #495057;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            padding: 20px;
        }

        .card .text-primary {
            color: #007bff !important;
        }

        .card .text-success {
            color: #28a745 !important;
        }

        .card .text-info {
            color: #17a2b8 !important;
        }

        .card .text-gray-800 {
            color: #343a40;
        }

        .card .font-weight-bold {
            font-weight: 700;
        }

        .card .progress-bar {
            background-color: #17a2b8;
        }

        .card-icon {
            font-size: 2rem;
            color: #adb5bd;
        }

        .card-icon.primary {
            color: #007bff;
        }

        .card-icon.success {
            color: #28a745;
        }

        .card-icon.info {
            color: #17a2b8;
        }

        /* Topbar User Info Dropdown */
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 8px;
            border: none;
        }

        /* Chart Styles */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Dashboard</h3>
            </div>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#"><i class="fas fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-chart-line"></i> Reports</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-users"></i> Users</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-cog"></i> Settings</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light topbar">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-user-circle"></i> Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container">
                <!-- Dashboard Cards -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Sales</h5>
                                <h3 class="card-text">$5,000</h3>
                                <i class="fas fa-dollar-sign card-icon primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Active Users</h5>
                                <h3 class="card-text">1,200</h3>
                                <i class="fas fa-users card-icon success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">New Signups</h5>
                                <h3 class="card-text">150</h3>
                                <i class="fas fa-user-plus card-icon info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reports Section -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sales Overview</h5>
                                <div class="chart-container">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">User Growth</h5>
                                <div class="chart-container">
                                    <canvas id="userGrowthChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Management Section -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h3>User Management</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#editUserModal">Edit</button>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                                <!-- Additional users can be added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="userName">Name</label>
                            <input type="text" class="form-control" id="userName" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email address</label>
                            <input type="email" class="form-control" id="userEmail" placeholder="Enter email">
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            // Sales Overview Chart
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'Sales',
                        data: [1200, 1900, 3000, 5000, 2000, 3000],
                        backgroundColor: 'rgba(38, 185, 154, 0.7)',
                        borderColor: 'rgba(38, 185, 154, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // User Growth Chart
            var ctx2 = document.getElementById('userGrowthChart').getContext('2d');
            var userGrowthChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'New Users',
                        data: [30, 50, 100, 80, 70, 90],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
