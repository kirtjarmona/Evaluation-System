<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Faculty Evaluation System</title>
	<!-- ------------- TEST-->
	<link rel="stylesheet" href="../dist/css/bootstrap.css" >
	<link rel="stylesheet" href="../dist/css/bootstrap.min.css" >
	<link rel="stylesheet" href="../fontawesome/web-fonts-with-css/css/font-awesome.css">
   	<script src="../dist/js/jquery.min.js"></script>
   	<script src="../dist/js/bootstrap.min.js"></script>
	<!-- ------------- -->
	<link rel="stylesheet" href="../style.css">
	<style type="text/css">

			/* The container */
			@media (min-width: 576px) {
				a.navbar-brand, div.navbar-collapse{
					padding-left: 8rem;
					padding-right: 8rem;
				}
			}
		
			/* Create a custom checkbox */
			.checkmark {
			    position: absolute;
			    top: 0;
			    left: 0;
			    height: 25px;
			    width: 25px;
			    background-color: #eee;
			}

			/* On mouse-over, add a grey background color */
			.container:hover input ~ .checkmark {
			    background-color: #ccc;
			}

			/* When the checkbox is checked, add a blue background */
			.container input:checked ~ .checkmark {
			    background-color: #2196F3;
			}

			/* Create the checkmark/indicator (hidden when not checked) */
			.checkmark:after {
			    content: "";
			    position: absolute;
			    display: none;
			}

			/* Show the checkmark when checked */
			.container input:checked ~ .checkmark:after {
			    display: block;
			}

			/* Style the checkmark/indicator */
			.container .checkmark:after {
			    left: 9px;
			    top: 5px;
			    width: 5px;
			    height: 10px;
			    border: solid white;
			    border-width: 0 3px 3px 0;
			    -webkit-transform: rotate(45deg);
			    -ms-transform: rotate(45deg);
			    transform: rotate(45deg);
			}


			.navbar-toggle .icon-bar:nth-of-type(2) {
				  top: 1px;
			}

			.navbar-toggle .icon-bar:nth-of-type(3) {
			  	top: 2px;
			}

			.navbar-toggle .icon-bar {
				  position: relative;
				  transition: all 500ms ease-in-out;
			}

			.navbar-toggle.active .icon-bar:nth-of-type(1) {
				  top: 6px;
				  transform: rotate(45deg);
			}

			.navbar-toggle.active .icon-bar:nth-of-type(2) {
				  background-color: transparent;
			}

			.navbar-toggle.active .icon-bar:nth-of-type(3) {
				  top: -6px;
				  transform: rotate(-45deg);
			}
			</style>
<style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      padding-bottom: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }

    /*
 
     */
    .highcharts-button.highcharts-contextbutton, .highcharts-button.highcharts-contextbutton.highcharts-button-normal, .highcharts-axis-labels.highcharts-yaxis-labels, .highcharts-credits{
    	display: none;
    }
  </style>
  <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

    <script src="../js/highcharts-3d.js"></script>
</head>