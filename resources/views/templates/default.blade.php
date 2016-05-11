<!DOCTYPE html>
<html lang="en">
    <head>
    	<meta charset="UTF-8">
        <title>Project</title>

        <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <script type="text/javascript" src="public/js/jquery-1.11.3.min.js" ></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


        
         <style>
            .outter-class iframe {
            width: 100%;
            }

            /* Style The Dropdown Button #4CAF50*/
            .dropbtn {
                background-color: #F8F8F8;
                color: #777777;
                padding: 16px;
                font-size: 16px;
                border: none;
                cursor: pointer;
            }

            /* The container <div> - needed to position the dropdown content */
            .dropdown {
                position: relative;
                display: inline-block;
                z-index: 1;
            }

            /* Dropdown Content (Hidden by Default) */
            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            }

            /* Links inside the dropdown */
            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            /* Change color of dropdown links on hover */
            .dropdown-content a:hover {background-color: #E6E6E6}

            /* Show the dropdown menu on hover */
            .dropdown:hover .dropdown-content {
                display: block;
            }

            /* Change the background color of the dropdown button when the dropdown content is shown  3e8e41*/
            .dropdown:hover .dropbtn {
                background-color: #E6E6E6;
                color: black;
            }
            select {
                width: 100%;
                padding: 16px 20px;
                border: none;
                border-radius: 4px;
                background-color: #f1f1f1;
            }
            input[type=text] {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                box-sizing: border-box;
            }
            table {
               border-collapse: collapse;
               width: 100%;
            }

            th, td {
                text-align: center;
                padding: 15px;
            }

            tr:hover {background-color: #FDFEFE}
            th {
                background-color: #E5E7E9;
                color: #34495E;
            }
            tr {
                background-color: #F2F3F4;
                color: #34495E;
            }

            .button {
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                padding: 16px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                -webkit-transition-duration: 0.4s; /* Safari */
                transition-duration: 0.4s;
                cursor: pointer;
            }
            .button2 {
                background-color: white; 
                color: black; 
                border: 2px solid #008CBA;
                padding-left: 0;
                padding-right: 0;
                width: 100%;
            }

            .button2:hover {
                background-color: #008CBA;
                color: white;
            }

            .search-btn {
                background-color: #D7DBDD; 
                color: black; 
                border: 2px solid #CACFD2;
                padding-left: 0;
                padding-right: 0;
                width: 100%;
            }

            .search-btn:hover {
                background-color: #95A5A6;
                color: white;
            }
            .device-btn {
                background-color: #F2F3F4; 
                color: black; 
                border: 2px solid #FBFCFC;
                padding-left: 0;
                padding-right: 0;
                width: 100%;
            }

            .device-btn:hover {
                background-color: #E5E8E8;
                color: #2E4053;
            }
            .outter-class {
                max-width: 1170px;
                width: 100%;
                overflow: hidden;
            }

            .no-pad {
                padding: 0 !important;
            }

            .no-gap {
                margin: 0 !important;
            }
            .container{
                padding: 0 !important
            }
            .heading-color{
                color: #008CBA;
            }
            a {
                color: #0060B6;
                text-decoration: none;
            }

            a:hover 
            {
                 color:#00A0C6; 
                 text-decoration:none; 
                 cursor:pointer;  
            }

        </style>
    </head>
    <body>
    	@include('templates.partials.navigation')
        <div class="container">
        	
      		@yield('content')
    </body>
</html>