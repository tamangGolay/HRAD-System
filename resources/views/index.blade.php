<!-- Stored in resources/views/pages/incoming.blade.php -->

@extends('layouts.masterdefault') @section('title', 'Home')
<style>
.boxinfo {
	font-size: 12px;
	display: flex;
	flex-wrap: wrap;
	flex-direction: row;
	align-items: flex-start;
	justify-content: space-between;
}

.ibox {
	font-size: 1rems;
	display: flex;
	flex-direction: column;
	align-items: stretch;
	justify-content: space-evenly;
	min-width: 100px;
}

.ibox:nth-of-type(1) {
	border: 1px solid green;
	border-radius: 5%;
	background-color: #999922;
}

.ibox:nth-of-type(2) {
	border: 1px solid orange;
	border-radius: 5%;
	background-color: #666600;
}

.ibox:nth-of-type(3) {
	border: 1px solid blue;
	border-radius: 5%;
	background-color: #006666;
}

.ibox h2 {
	color: white;
	font-weight: bold;
	font-size: 1rems;
}

.ibox p {
	font-size: 12px;
	color: white;
}

.newsbox {
	width: 1rems;
	margin-top: 3px;
	display: flex;
	flex-direction: column;
	align-items: stretch;
	background-color: #cccccc;
}

.newsbox .card-header {
	background-color: #aaaaaa;
	color: white;
	padding: 0;
}

.newsbox .card-header h2 {
	color: brown;
	padding-left: 10px;
	font-weight: 400;
}
</style> @section('content')
<div class="container-fluid">
	<!-- Small boxes (Stat box) -->
	<div class="boxinfo">
		<div class="col-md-6 col-lg-4 ibox">
			<!-- small box -->
			<div class="one">
				<div id="inner">
					<h2>Frontliners<h2>
                    <p>Total Registered:</p>
                    <p>Total Deployed:</p>
                </div>
                <div class="icon">
                <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
             </div>
            </div>      
    <!-- ./col -->
            <div class="col-md-6 col-lg-4 ibox">
            <!-- small box -->
                <div id="two">
                    <div class="inner">
                        <h2>Quarantine<h2>
                        <p>Total Quarantine:</p>
                        <p>Total Completed:</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
          <!-- ./col -->
              <div class="col-md-6 col-lg-4 ibox">
                    <div id="three">
                        <div class="inner">
                            <h2>Transporation<h2>
                            <p>Total Vehicles:</p>
                            <p>Total Deployed:</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-person-add"></i>
                        </div>
                        <a href="/starter.html" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
              </div>
          <!-- ./col -->
          </div>
            <div class="newsbox">                
                    <div class="card card-outline">
                        <div class="card-header">
                         <h2>News</h2> </div>
				<div class="card-body">
					<p>Updated by ...</p>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->@endsection