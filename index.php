<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Image Carousel with Text</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Adjust carousel height as needed */
    .carousel-item {
      height: 300px; /* Change this to your desired height */
    }

    /* Center align text */
    .carousel-caption {
      text-align: center;
    }
    p{
        color: black;
    }
    h5{
        color: black;
    }

    /* Change color of carousel control icons */
    .carousel-control-prev-icon svg,
    .carousel-control-next-icon svg {
      fill: #6200EE; /* Change to desired color */
    }

    /* Change color of arrow indicators on hover */
    .carousel-control-prev:hover .carousel-control-prev-icon svg,
    .carousel-control-next:hover .carousel-control-next-icon svg {
      fill: #6200EE; /* Change to desired color */
    }
  </style>
</head>
<body>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="...">
      <div class="carousel-caption">
        <h5>Lost Something? </h5>
        <p>Create an ad of your lost item and let your friends know</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="...">
      <div class="carousel-caption">
        <h5>Second Slide</h5>
        <p>This is the second slide's text</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="...">
      <div class="carousel-caption">
        <h5>Third Slide</h5>
        <p>This is the third slide's text</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
