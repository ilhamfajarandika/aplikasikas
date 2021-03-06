<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-9">
		<div class="card m-b-30">
			<div class="card-body">
				<h5 class="header-title pb-3 mt-0">Data Transaksi Bulan</h5>
				<div id="line-chart" style="height:400px;"></div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-lg-12 col-xl-3">
		<div class="card m-b-30">
			<div class="card-header bg-primary d-flex rounded justify-content-between align-items-center py-3 px-4">
				<h5 class="m-0 header-title text-light">
                    <?php
                        $tanggal = tanggalLaporan(date('Y-m-d'));
                        $hari = substr($tanggal, 0, 2);
                        $bulan = bulanLaporan(date('Y-m-d'));
                        $tahun = date('Y');

                        echo "{$hari} {$bulan} {$tahun}";
                        ?>
                </h5>
				<h5 class=" text-light" id="clock"></h5>
			</div>
			
		</div>
	</div>
	<!-- <ul>
		<li>cek user yang sama</li>
		<li>tidak boleh login saat session</li>
	</ul> -->
</div>


<script src="https://cdn.jsdelivr.net/gh/jquery/jquery@3.2.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/wrick17/calendar-plugin@master/calendar.min.js"></script>

<script>
    $('tanggal').calendar();
	const tahun = new Date();

	function fWaktu() {
		var waktu = new Date();
		var jam = waktu.getHours();
		var menit = waktu.getMinutes();
		var detik = waktu.getSeconds();

		jam = updateWaktu(jam);
		menit = updateWaktu(menit);
		detik = updateWaktu(detik);

		document.getElementById("clock").innerText = jam + " : " + menit;
		var t = setTimeout(function () {
			fWaktu()
		}, 1000);
	}

	function updateWaktu(k) {
		if (k < 10) {
			return "0" + k;
		} else {
			return k;
		}
	}

	fWaktu();

	$.ajax({
		type: "post",
		url: "http://localhost/aplikasikas/home/chart",
		dataType: "json",
		success: function (data) {
			var dTran = data;
			var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

			function dataMasuk(bulan) {
				var dMasuk;
				const data = dTran[bulan].map((m, i) => {
					if (m.Pemasukan == null || m.Pengeluaran == null) {
						dMasuk = 0
					} else {
						[dMasuk] = [m.Pemasukan]
					}
				});
				return parseInt(dMasuk);
			}

			function dataKeluar(bulan) {
				var dKeluar;
				const data = dTran[bulan].map((m, i) => {
					if (m.Pemasukan == null || m.Pengeluaran == null) {
						dKeluar = 0
					} else {
						[dKeluar] = [m.Pengeluaran]
					}
				});
				return parseInt(dKeluar);
			}

			rData = [{
				tahun: tahun.getFullYear() + '-01', // <-- valid timestamp strings
				masuk: dataMasuk("January"),
				keluar: dataKeluar("January")
			}, {
				tahun: tahun.getFullYear() + '-02',
				masuk: dataMasuk("February"),
				keluar: dataKeluar("February")
			}, {
				tahun: tahun.getFullYear() + '-03',
				masuk: dataMasuk("March"),
				keluar: dataKeluar("March")
			}, {
				tahun: tahun.getFullYear() + '-04',
				masuk: dataMasuk("April"),
				keluar: dataKeluar("April")
			}, {
				tahun: tahun.getFullYear() + '-05',
				masuk: dataMasuk("May"),
				keluar: dataKeluar("May")
			}, {
				tahun: tahun.getFullYear() + '-06',
				masuk: dataMasuk("June"),
				keluar: dataKeluar("June")
			}, {
				tahun: tahun.getFullYear() + '-07',
				masuk: dataMasuk("July"),
				keluar: dataKeluar("July")
			}, {
				tahun: tahun.getFullYear() + '-08',
				masuk: dataMasuk("August"),
				keluar: dataKeluar("August")
			}, {
				tahun: tahun.getFullYear() + '-09',
				masuk: dataMasuk("September"),
				keluar: dataKeluar("September")
			}, {
				tahun: tahun.getFullYear() + '-10',
				masuk: dataMasuk("October"),
				keluar: dataKeluar("October")
			}, {
				tahun: tahun.getFullYear() + '-11',
				masuk: dataMasuk("November"),
				keluar: dataKeluar("November")
			}, {
				tahun: tahun.getFullYear() + '-12',
				masuk: dataMasuk("December"),
				keluar: dataKeluar("December")
			}, ]

			Morris.Line({
				element: 'line-chart',
				data: rData,
				xkey: 'tahun',
				ykeys: ['masuk', 'keluar'],
				ymax: 5000000,
				labels: ['Kas Masuk', 'Kas Keluar'],
				hideHover: true,
				xLabelFormat: function (x) { // <--- x.getMonth() returns valid index
					var month = months[x.getMonth()];
					return month;
				},

			})
		}
	});

</script>
