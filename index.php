<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <title>H2OVue</title>
	
	<style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
			background-image: url("water.png");			
        }
		
		#dw_btn{
			margin-left:-25%;
			margin-top:-7%;
		}
    </style>

</head>

<body >
	<section id="details">
		<div class="container">
			<div class="row ">
				<div class="card">
						<div class="card-header"><h4 class="text-center my-2">WATER BILL MANAGEMENT SYSTEM</h4></div>
						<div class="card-body">
							<div class="row">
								<div class="col-9">Click here to download your Water Bill</div>
								<div class="col-3"><a id="dw_btn" href="invoice.php" class="btn btn-md btn-primary" id="downloadButton">Download</a></div>
							</div>
						</div>	
					</div>
			</div>
		</div>
	</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<script>
    // Get the current year for the copyright
    $('#year').text(new Date().getFullYear());
</script>

</body>
</html>
