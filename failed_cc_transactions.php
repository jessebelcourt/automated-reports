<?php
require 'init.php';

$HB_HEAD_JS[] = 'https://d3js.org/d3.v3.min.js';
$HB_HEAD_CSS = array(
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
    'css/accountingstats.css',
);

require 'page_top.php';
?>

<div class="container">
    <h1>Failed Credit Card Transactions between <span id="start-date-label"></span> <span id="and" style="display: none;"> AND </span> <span id="end-date-label"></span></h1>
    <div id="chart-container"></div>
    <div id="table-section" class="row">
        <div class="col-md-2">
            <label for="startdate">Start Date</label>
            <input type="text" name="startdate" id="startdate" placeholder="08/15/2016" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="enddate">End Date</label>
            <input type="text" name="enddate" id="enddate" placeholder="01/15/2017" class="form-control">
        </div>
        <div class="col-md-2">
            <button id="getlist" class="btn btn-primary btn-block">Find</button>
        </div>
        <div class="col-md-2">
            <button id="download" class="btn btn-primary btn-block">Download CSV</button>
        </div>
        <div class="col-md-2">
            <button id="download-for-excel" class="btn btn-primary btn-block">CSV for Excel</button>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Amount</th>
                <th id="trans-id-col">Transaction ID</th>
                <th>Domain ID</th>
                <th id="date-col">Date</th>
                <th>Domain Type</th>
                <th id="status-col">Status</th>
                <th>Client ID</th>
                <th>Total Transaction Amount</th>
                <th>Balance</th>
                <th>Payment Since CC Failure</th>
                <th>Domain</th>
            </tr>
        </thead>
    </table>
</div>

<div class="loading-wrapper off">
    <svg id="loading-animation" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="360px" height="45px" viewBox="0 0 512 64" xml:space="preserve"><path fill="#f4a4b4" fill-opacity="0.42" fill-rule="evenodd" d="M486.4 19.2A12.8 12.8 0 1 1 473.6 32a12.8 12.8 0 0 1 12.8-12.8zm-51.2 0A12.8 12.8 0 1 1 422.4 32a12.8 12.8 0 0 1 12.8-12.8zm-51.2 0A12.8 12.8 0 1 1 371.2 32 12.8 12.8 0 0 1 384 19.2zm-51.2 0A12.8 12.8 0 1 1 320 32a12.8 12.8 0 0 1 12.8-12.8zm-51.2 0A12.8 12.8 0 1 1 268.8 32a12.8 12.8 0 0 1 12.8-12.8zm-51.2 0A12.8 12.8 0 1 1 217.6 32a12.8 12.8 0 0 1 12.8-12.8zm-51.2 0A12.8 12.8 0 1 1 166.4 32a12.8 12.8 0 0 1 12.8-12.8zm-51.2 0A12.8 12.8 0 1 1 115.2 32 12.8 12.8 0 0 1 128 19.2zm-51.2 0A12.8 12.8 0 1 1 64 32a12.8 12.8 0 0 1 12.8-12.8zm-51.2 0A12.8 12.8 0 1 1 12.8 32a12.8 12.8 0 0 1 12.8-12.8z"/><g transform="translate(760.8 0)"><path fill="#e5274d" fill-opacity="1" fill-rule="evenodd" d="M-119.6,10.24A21.76,21.76,0,0,1-97.84,32,21.76,21.76,0,0,1-119.6,53.76,21.76,21.76,0,0,1-141.36,32,21.76,21.76,0,0,1-119.6,10.24Zm-51.2,0A21.76,21.76,0,0,1-149.04,32,21.76,21.76,0,0,1-170.8,53.76,21.76,21.76,0,0,1-192.56,32,21.76,21.76,0,0,1-170.8,10.24Zm-51.2,0A21.76,21.76,0,0,1-200.24,32,21.76,21.76,0,0,1-222,53.76,21.76,21.76,0,0,1-243.76,32,21.76,21.76,0,0,1-222,10.24Zm-51.2,0A21.76,21.76,0,0,1-251.44,32,21.76,21.76,0,0,1-273.2,53.76,21.76,21.76,0,0,1-294.96,32,21.76,21.76,0,0,1-273.2,10.24Zm-51.2,0A21.76,21.76,0,0,1-302.64,32,21.76,21.76,0,0,1-324.4,53.76,21.76,21.76,0,0,1-346.16,32,21.76,21.76,0,0,1-324.4,10.24Zm-51.2,0A21.76,21.76,0,0,1-353.84,32,21.76,21.76,0,0,1-375.6,53.76,21.76,21.76,0,0,1-397.36,32,21.76,21.76,0,0,1-375.6,10.24Zm-51.2,0A21.76,21.76,0,0,1-405.04,32,21.76,21.76,0,0,1-426.8,53.76,21.76,21.76,0,0,1-448.56,32,21.76,21.76,0,0,1-426.8,10.24Zm-51.2,0A21.76,21.76,0,0,1-456.24,32,21.76,21.76,0,0,1-478,53.76,21.76,21.76,0,0,1-499.76,32,21.76,21.76,0,0,1-478,10.24Zm-51.2,0A21.76,21.76,0,0,1-507.44,32,21.76,21.76,0,0,1-529.2,53.76,21.76,21.76,0,0,1-550.96,32,21.76,21.76,0,0,1-529.2,10.24Zm-51.2,0A21.76,21.76,0,0,1-558.64,32,21.76,21.76,0,0,1-580.4,53.76,21.76,21.76,0,0,1-602.16,32,21.76,21.76,0,0,1-580.4,10.24Zm-51,2.56A19.2,19.2,0,0,1-612.2,32a19.2,19.2,0,0,1-19.2,19.2A19.2,19.2,0,0,1-650.6,32,19.2,19.2,0,0,1-631.4,12.8Zm-51,2.56A16.64,16.64,0,0,1-665.76,32,16.64,16.64,0,0,1-682.4,48.64,16.64,16.64,0,0,1-699.04,32,16.64,16.64,0,0,1-682.4,15.36ZM-68.8,12.8A19.2,19.2,0,0,1-49.6,32,19.2,19.2,0,0,1-68.8,51.2,19.2,19.2,0,0,1-88,32,19.2,19.2,0,0,1-68.8,12.8Zm51.2,2.56A16.64,16.64,0,0,1-.96,32,16.64,16.64,0,0,1-17.6,48.64,16.64,16.64,0,0,1-34.24,32,16.64,16.64,0,0,1-17.6,15.36Z"/><animateTransform attributeName="transform" type="translate" values="44 0;95.2 0;146.4 0;197.6 0;248.8 0;300 0;351.2 0;402.4 0;453.6 0;504.8 0;556 0;607.2 0;658.4 0;709.6 0;760.8 0;812 0;863.2 0;914.4 0;965.6 0;1016.8 0;1068 0;1119.2 0;1170.4 0;1221.6 0;1272.8 0;1324 0" calcMode="discrete" dur="2160ms" repeatCount="indefinite"/></g></svg>
</div>

<script>
    class DataVis {

        constructor() {
            this.table = d3.select("table");
            this.thead = this.table.select("thead");
            this.tbody = this.table.append("tbody");

            this.svg = d3.select("#chart-container")
                            .append("svg")
                            .append("g");

            this.svg.append("g").classed("slices", true);
            this.svg.append("g").classed("labels", true);
            this.svg.append("g").classed("lines", true);

            d3.select("#chart-container")
                .append("div")
                .attr("id", "legend")
                .append("ul");

            d3.select("#legend")
                .append("h2")
                .style("opacity", 0)
                .text("Current Status");

            this.width = 960;
            this.height = 450;
            this.radius = Math.min(this.width, this.height) / 2;

            this.svg.attr("transform", "translate(" + this.width / 2 + "," + this.height / 2 + ")");
        }

        sortByStatus() {
            this.tbody.selectAll("tr").sort((a, b) => d3.ascending(a.status, b.status) );
        }

        sortByDate() {
            this.tbody.selectAll("tr").sort((a, b) => d3.ascending(new Date(a.date), new Date(b.date)) );
        }

        sortByTransactionId() {
            this.tbody.selectAll("tr").sort((a, b) => d3.ascending(a.transaction_id, b.transaction_id));

        }

        tableToCSV(forExcel=true) {
            let data = d3.selectAll("tbody tr").data();
            if(data.length) {
                if(forExcel) {
                    var csvData = data.map(d => {
                            return `${d.id},${d.amount},${d.transaction_id},${d.domain_id},${d.date},${d.domain_type},${d.status},${d.client_id},${d.total_transaction_amount},${d.balance},${d.payment_since_cc_failure},=HYPERLINK("${window.location.origin}/domain.php?id=${d.domain_id}")`;
                    });
                } else {
                    var csvData = data.map(d => {
                        return `${d.id},${d.amount},${d.transaction_id},${d.domain_id},${d.date},${d.domain_type},${d.status},${d.client_id},${d.total_transaction_amount},${d.balance},${d.payment_since_cc_failure},${window.location.origin}/domain.php?id=${d.domain_id}`;
                    });
                }

                return ["id, amount, transaction_id, domain_id, date, domain_type, status, client_id, total_transaction_amount, balance, payment_since_cc_failure, office_link"].concat(csvData).join("\n");
            } else {
                alert("No data selected");
            }
        }

        download(csv, fileName) {
            let downloadLink = document.createElement("a");
            downloadLink.download = fileName;
            downloadLink.href = "data:text/csv;charset=utf-8," + encodeURI(csv);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        failedCCAttempt(startDate, endDate) {
            this.startDate = startDate;
            this.endDate = endDate;
            d3.select(".loading-wrapper").classed("off", false);
            d3.json(`${window.location.origin}/failed_cc_stats_get.php?startdate=${startDate}&enddate=${endDate}`, (error, data) => {
            // d3.csv(`${window.location.origin}/quarter_report.csv`, (error, data) => { //TODO: Remove after demo.

                d3.select(".loading-wrapper").classed("off", true);

                d3.select("#legend h2").style("opacity", 1);

                let statusObj = {};
                let statusArr = [];
                let domain = [];

                data.map( d => {
                    if(d.status in statusObj) {
                        statusObj[d.status] += 1;
                    } else {
                        statusObj[d.status] = 1;
                    }
                    if(domain.indexOf(d.status) === -1) {
                        domain.push(d.status);
                    }
                });

                Object.keys(statusObj).forEach((d, i) => statusArr.push({"status": d, "count": statusObj[d]}));

                /*============= Chart =================*/

                let pie = d3.layout.pie().sort(null).value(d => d.count);

                let arc = d3.svg.arc().outerRadius(this.radius * 1.0).innerRadius(this.radius * .6);

                let color = d3.scale.category20().domain(domain);

                let slice = this.svg.select(".slices")
                                    .selectAll("g.slice")
                                    .select("path")
                                    .data(pie(statusArr))
                                    .style("fill", d => color(d.data.status))
                                    .attr("d", d => arc(d));

                slice.enter()
                        .append("g")
                        .classed("slice", true)
                        .append("path")
                        .attr("d", d => arc(d))
                        .style("fill", d => color(d.data.status));

                slice.exit().remove();

                /*=============== Chart Legend ============*/

                //Update
                let legend =d3.select("#legend")
                                .selectAll("li")
                                .data(statusArr)
                                .style("color", d => color(d.status))
                                .text(d => {
                                    let calculated = (Math.round( (((d.count / data.length) * 100)) * 10) / 10).toFixed(2);
                                    if (calculated < 1) {
                                        calculated = " < 1";
                                    }
                                    return d.status + " -- " + calculated + "%";
                                });

                //Enter
                legend.enter()
                        .append("li")
                        .style("color", d => color(d.status))
                        .classed("legend-item", true)
                        .append("text")
                        .text(d => {
                            let calculated = (Math.round( (((d.count / data.length) * 100)) * 10) / 10).toFixed(2);
                            if (calculated < 1) {
                                calculated = " < 1";
                            }
                            return d.status + " -- " + calculated + "%";
                        });

                //Exit
                legend.exit().remove();


                let cols = ["id", "amount", "transaction_id", "domain_id", "date", "domain_type", "status", "client_id", "total_transaction_amount", "balance", "payment_since_cc_failure", "office_link"];

                //Update
                let rows = this.tbody.selectAll("tr").data(data);

                //Enter
                rows.enter()
                        .append("tr")
                        .classed("table-rows", true)
                        .on("mouseenter", function() {
                            d3.select(this).classed("active", true);
                        })
                        .on("mouseleave", function() {
                            d3.select(this).classed("active", false);
                        });

                //Update
                let cells = this.tbody
                                .selectAll(".table-rows")
                                .selectAll("td")
                                .data(row => {
                                    return cols.map(col => {
                                        return { id: row["id"], column: col, value: row[col], domain_id: row["domain_id"], domain: row["domain"]};
                                    })
                                })
                                .text( (d, i) => { return d.value; } )
                                .each(function(d) {
                                    let cell = d3.select(this);
                                    if(d.column == "office_link") {
                                        d3.select(this)
                                            .append("a")
                                            .attr("target", "_blank")
                                            .attr("href", d => `${window.location.origin}/domain.php?id=${d.domain_id}`)
                                            .text( d => d.domain);
                                    }
                                });

                //Enter
                cells.enter()
                        .append("td")
                        .text( (d, i) => {
                            return d.value; } )
                        .each(function(d) {
                            let cell = d3.select(this);
                            if(d.column == "office_link") {
                                d3.select(this)
                                    .append("a")
                                    .attr("target", "_blank")
                                    .attr("href", d => `${window.location.origin}/domain.php?id=${d.domain_id}`)
                                    .text( d => d.domain);
                            }
                        });

                //Exit
                cells.exit().remove();

                //Exit
                rows.exit().remove();

            });
        }
    }

    let vis = new DataVis();
    let queryDict = {};
    let startDate = document.getElementById("startdate");
    let endDate = document.getElementById("enddate");
    let findBtn = document.getElementById("getlist");
    let downloadBtn = document.getElementById("download");
    let downloadForExcelBtn = document.getElementById("download-for-excel");
    let sortByStatusCol = document.getElementById("status-col");
    let sortByDateCol = document.getElementById("date-col");
    let sortByTransId = document.getElementById("trans-id-col");
    let startDateLabel = document.getElementById("start-date-label");
    let endDateLabel = document.getElementById("end-date-label");
    let and = document.getElementById("and");

    // get GET parameters
    location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})

    if (queryDict["startdate"] && queryDict["enddate"]) {
        vis.failedCCAttempt(queryDict["startdate"], queryDict["enddate"]);
        startDateLabel.innerHTML = queryDict["startdate"];
        endDateLabel.innerHTML = queryDict["enddate"];
        and.style.display = "inline";
    }

    findBtn.addEventListener("click", e => {
        e.preventDefault();
        let sd = formatDate(startDate.value);
        let ed = formatDate(endDate.value);
        if(sd && ed) {
            startDateLabel.innerHTML = sd;
            endDateLabel.innerHTML = ed;
            and.style.display = "inline";
            vis.failedCCAttempt(sd, ed);
        } else {
            alert("Please use the following format \n dd/mm/yyyy");
        }
    });

    sortByStatusCol.addEventListener("click", e => vis.sortByStatus());
    sortByDateCol.addEventListener("click", e => vis.sortByDate());
    sortByTransId.addEventListener("click", e => vis.sortByTransactionId());

    downloadBtn.addEventListener("click", e => {
        e.preventDefault()
        let csv = vis.tableToCSV(false);
        let fileName = (vis.startDate && vis.endDate) ? `failed-cc-transactions-between-${vis.startDate}-and-${vis.endDate}.csv` : false;
        fileName ? vis.download(csv, fileName) : alert("No Selected Dates");
    });

    downloadForExcelBtn.addEventListener("click", e => {
        e.preventDefault();
        let csv = vis.tableToCSV();
        let fileName = (vis.startDate && vis.endDate) ? `failed-cc-transactions-between-${vis.startDate}-and-${vis.endDate}.csv` : false;
        fileName ? vis.download(csv, fileName) : alert("No Selected Dates");
    });

    function formatDate(inDate) {
        let dateStr = inDate.replace(/\s/g, "");
        let re = /(\d{1,2})\/(\d{1,2})\/(\d{4})/;
        let matches = re.exec(dateStr);
        if (matches && matches[1] && matches[2] && matches[3]) {
            let month = matches[1];
            let day = matches[2];
            let year = matches[3];
            return year + "-" + month + "-" + day;
        } else {
            return false;
        }
    }
</script>
<?php
require 'page_bottom.php';
