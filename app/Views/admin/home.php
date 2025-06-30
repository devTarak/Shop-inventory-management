<div class="container-fluid px-3 mt-4 d-flex flex-column justify-content-between" style="min-height: 90vh;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>
                            <?= esc($total_products) ?>
                        </h3>
                        <h5>Total Products</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>
                            <?= esc($today_sales) ?>
                        </h3>
                        <h5>Today Sales</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>
                            <?= esc($last_sold_status) ?>
                        </h3>
                        <h5>Last Sales Status</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 mb-4">
                <div class="card text-center">
                    <div class="card-body MonthlySale">
                        <h3>
                            <?= esc($last_month_profit) ?>
                        </h3>
                        <h5>last Month Revenue</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="text-center mt-5">
            <h3>নিশ্চয়ই আল্লাহ সবচেয়ে উত্তম পরিকল্পনাকারী।</h3>
            <h6>[সূরা আনফাল : ৩০ এবং আল ইমরান ৫৪ ]</h6>
        </div>
    </div>
    <div class="container text-center mb-5">
        <div class="d-flex justify-content-center mt-4">
            <div id="digitalClock" style="font-size:5rem; font-weight:bold;"></div>
        </div>
    </div>
</div>
<script>
    function updateClock() {
        const now = new Date();
        let h = now.getHours();
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        h = h ? h : 12;
        h = h.toString().padStart(2, '0');
        let m = now.getMinutes().toString().padStart(2, '0');
        let s = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('digitalClock').textContent = `${h}:${m}:${s} ${ampm}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>