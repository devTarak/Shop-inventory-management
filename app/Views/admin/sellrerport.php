<div class="container-fluid px-3" style="overflow-y: auto;">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <h3 class="mb-0">Sales Report</h3>
        <form method="POST" class="row g-3 align-items-center" id="searchReportForm">
            <div class="col-auto">
                <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
            </div>
            <div class="col-auto">
                <input type="date" class="form-control" id="end_date" name="end_date" placeholder="End Date">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary" id="search_Report_btn">Search</button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover w-100">
            <thead class="table-dark">
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity Sold</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Date Sold</th>
                </tr>
            </thead>
            <tbody id="reportTableBody">
                <tr>
                    <td colspan="6" class="text-center">No Sell found.</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Total Sell Amount</td>
                    <td colspan="2" class="text-center">00.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
            // Set default dates: one month ago for startDate, today for endDate
            const today = new Date();
            const oneMonthAgo = new Date();
            oneMonthAgo.setMonth(today.getMonth() - 1);

            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            document.getElementById('start_date').value = formatDate(oneMonthAgo);
            document.getElementById('end_date').value = formatDate(today);

            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (!startDate || !endDate) {
                alert('Please select both start and end dates.');
                return;
            }

            $.ajax({
                url: '<?= base_url('admin/reports/search') ?>',
                type: 'POST',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    // Handle the response to update the table
                    let tbody = $('#reportTableBody');
                    tbody.empty();
                    if (response && response.length > 0) {
                        response.forEach(function(row, index) {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${row.name}</td>
                                    <td>${row.product_quantity}</td>
                                    <td>${row.total_price}</td>
                                    <td>${row.date}</td>
                                </tr>
                            `);
                        });
                        tbody.append(`
                            <tr class="table-dark">
                                <td colspan="3" class="text-center">Total Sell Amount</td>
                                <td colspan="2" >${response.reduce((sum, row) => sum + parseFloat(row.total_price), 0).toFixed(2)}</td>
                            </tr>
                        `);
                    } else {
                        tbody.append('<tr><td colspan="6" class="text-center">No Sell found.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching reports:', error);
                }
            });
    });
    $(document).on('submit', '#searchReportForm', function(e) {
        e.preventDefault();
        const startDates = $('#start_date').val();
        const endDates = $('#end_date').val();

        if (!startDates || !endDates) {
            alert('Please select both start and end dates.');
            return;
        }

        $.ajax({
            url: '<?= base_url('admin/reports/search') ?>',
            type: 'POST',
            data: {
                start_date: startDates,
                end_date: endDates
            },
            success: function(response) {
                let tbody = $('#reportTableBody');
                tbody.empty();
                if (response && response.length > 0) {
                    response.forEach(function(row, index) {
                        tbody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.name}</td>
                                <td>${row.product_quantity}</td>
                                <td>${row.total_price}</td>
                                <td>${row.date}</td>
                            </tr>
                        `);
                    });
                    tbody.append(`
                            <tr class="table-dark">
                                <td colspan="3" class="text-center">Total Sell Amount</td>
                                <td colspan="2" >${response.reduce((sum, row) => sum + parseFloat(row.total_price), 0).toFixed(2)}</td>
                            </tr>
                        `);
                } else {
                    tbody.append('<tr><td colspan="6" class="text-center">No Sell found.</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching reports:', error);
            }
        });
    });
</script>