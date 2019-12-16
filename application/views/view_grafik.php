<?php $this->load->view('head') ?>
<body>
	<div class="inner-banner-agile">
		<header>
	        <a href="#menu" class="menu-link">
	            <span>toggle menu</span>
	        </a>

	        <nav id="menu" class="panel">
	            <ul>
	                <li>
	                    <a href="<?php echo base_url(); ?>">Beranda</a>
	                </li>
	                <li>
	                    <?php if ($this->m_user->logged_id()) {
	                        $username = $this->session->userdata('username');?>
	                        <a href="<?php echo base_url(); ?>c_admin/data_jalan_admin/152">Data Jalan</a>
	                    <?php } else {?>
	                        <a href="<?php echo base_url(); ?>c_user/data_jalan/152">Data Jalan</a>
	                    <?php } ?>
	                </li>
	                <li>
	                    <?php if ($this->m_user->logged_id()) {
	                        $username = $this->session->userdata('username');?>
	                        <a href="<?php echo base_url(); ?>c_admin/laporan_jalan_admin/152">Laporan Jalan</a>
	                    <?php } else {?>
	                        <a href="<?php echo base_url(); ?>c_user/laporan_jalan/152">Laporan Jalan</a>
	                    <?php } ?>
	                </li>
	                <li>
	                    <a href="<?php echo base_url(); ?>view_grafik" class="active">Grafik Jalan</a>
	                </li>
	                <li>
	                    <?php if ($this->m_user->logged_id()) { 
	                        $username = $this->session->userdata('user_name');?>
	                        <a href="<?php echo base_url(); ?>logout">Logout (<?= $username?>)</a>
	                    <?php } else { ?>
	                        <a href="<?php echo base_url(); ?>login">Login</a>
	                    <?php } ?>
	                </li>
	            </ul>
	        </nav>
	    </header>
	</div>

	<div class="container">
        <div class="wthree-inner-sec">
            <h1 class="sec-title-w3 text-capitalize">grafik jalan</h1>
            <span class="block"></span>
        </div><br><br>

        <script src="assets/js/highcharts.js"></script>
		<script src="assets/js/exporting.js"></script>
		<script src="assets/js/offline-exporting.js"></script>
		
		<div class="grafik_panjang" style="width: 100%"></div>
		<br><br>
		<div class="grafik_rusak" style="width: 100%"></div>
		<?php $jalan = $this->m_user->getKecamatan();?>
		<br><br>
	    
	    <script type="text/javascript">
			$('.grafik_rusak').highcharts({
		 		chart: {
		 			renderTo: 'chart',
		 			type: 'column',
		 		},

		 		title: {
		 			text: 'Grafik Kerusakan Jalan'
		 		},

		 		xAxis: {
		 			categories: ['Baik', 'Sedang', 'Rusak', 'Rusak Berat']
		        },

		        yAxis: {
		        	title: {
		        		text: 'Panjang Jalan (km)'
		        	}
		        },

		        series: [
		        	{name: 'Grafik Kerusakan Jalan',
		        	data: <?php echo json_encode($grafik); ?>}
		        ],

		        legend:{enabled: false},

		        credits:{
		        	enabled: true,
		        	text : 'Infrastruktur Kabupaten Karanganyar',
		        },

		        plotOptions: {
					column: {
				  		colorByPoint: true,
						colors: [
						    '#50B432', 
						    '#DDDF00',
						    '#ff4000',
						    '#ff0000'
				   		]
					}
				}
			});

			$('.grafik_panjang').highcharts({
		 		chart: {
		 			renderTo: 'chart',
		 			type: 'column',
		 		},

		 		title: {
		 			text: 'Grafik Jalan Per Kecamatan'
		 		},

		 		xAxis: {
		 			categories: [
		 				<?php foreach ($jalan as $key) {
		 					echo "'".$key['nama']."',";
		 				} ?>
		 			]
		        },

		        yAxis: {
		        	title: {
		        		text: 'Panjang Jalan (km)'
		        	}
		        },

		        series: [
		        	{name: 'Panjang Jalan',
		        	data: <?php echo json_encode($grafik2); ?>}
		        ],

		        legend:{enabled: false},

		        credits:{
		        	enabled: true,
		        	text : 'Infrastruktur Kabupaten Karanganyar',
		        },

		        plotOptions: {
					column: {
				  		colorByPoint: true,
						colors: [
						    '#ff5050', 
						    '#ff66b3', 
						    '#9966ff', 
						    '#6699ff', 
						    '#007399', 
						    '#4dff4d', 
					    	'#e6e600', 
					    	'#ffa31a'
				   		]
					}
				}
			});
		</script>
    </div>
</body>