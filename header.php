<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Faculty Evaluation System</title>
	<link rel="stylesheet" href="./dist/css/bootstrap.css" >
		<link rel="stylesheet" href="./dist/css/bootstrap.min.css" >
			<link rel="stylesheet" href="./fontawesome/web-fonts-with-css/css/font-awesome.css">
			<script src="./dist/js/jquery.min.js"></script>
			<script src="./dist/js/bootstrap.min.js"></script>
			<!-- ------------- -->
			<link rel="stylesheet" href="style.css">
			<style type="text/css">
				html, body {
					background-color: #e9ecef;
				}
					/* The container */
					@media (min-width: 576px) {
						a.navbar-brand, div.navbar-collapse{
							padding-left: 8rem;
							padding-right: 8rem;
						}
					}
					/*@media (max-width: 419px) {
						a.navbar-brand, div.navbar-collapse{
							font-size: 100%;
						}
					}*/
					.shorttext { display: none; }
					@media (max-width: 419px) {
					.shorttext { display: inline-block; }
					.fulltext { display: none; }
					.container {
						padding-top:15px;
						margin-right: auto;
						margin-bottom: 0;
						margin-left: -5px;
						padding-right: 0;
						padding-bottom: 0;
						padding-left: 0;
						}
						.jumbotron {
							padding-top:50px;
						}
						body {
						padding:0;
						}
						.navbar-fixed-top, .navbar-fixed-bottom, .navbar-static-top {
						margin-left: 0;
						margin-right: 0;
						margin-bottom:0;
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
			<style type="text/css">
			/*HIGH CHART CSS*/
			#containergraph {
			height: 400px;
			min-width: 310px;
			max-width: 800px;
			margin: 0 auto;
			}
			g.highcharts-button.highcharts-contextbutton, g.highcharts-button.highcharts-contextbutton.highcharts-button-hover, g.highcharts-button.highcharts-contextbutton.highcharts-button-normal {
			display: none;
			}
			text.highcharts-credits {
			display: none;
			}
			/*END HIGH CHART CSS*/
			@media print {
			.container {
			width: auto;
			}
			
			}
			</style>
		</head>