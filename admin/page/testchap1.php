<div class="content">
      <div class="container-fluid">
      <div class="card-tools flex">
                    <span>Ngày Bắt Đầu</span>
                    <input type='date' class='form-control' id='datezoneMin' placeholder='Ngày Bắt Đầu' data-val='true' data-val-required='Ng&#xE0;y sinh l&#xE0; b&#x1EAF;t bu&#x1ED9;c' name='product.timemin' value=''>
                    <span>Ngày Kết Thúc</span>
                    <input type='date' class='form-control' id='datezoneMax' placeholder='Ngày Bắt Kết Thúc' name='product.timemax' value=''>
                    <input type="button" class="btn btn-tool btn-sm" value="Thống Kê" onclick="DrawChart()">
        </div>
        <div class="row">
          <div class="col-lg-6">
            
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Sản Phẩm Bán</h3>
                  
                  <!-- <a href="javascript:void(0);">View Report</a> -->
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span>Tổng Doanh Thu: </span>
                    <span class="text-bold text-lg sotiendaban"></span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>


              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Sản Phẩm Bán Ra</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <span>Loại Sản Phẩm</span>
                  <select style="height: 30px;" id="select-product" onchange="DrawChart()">
                                        <option value="all">Tất cả</option>
                                        <?php 
                                          foreach ($TypeData as $value) {
                                              echo "<option value='".$value["product_type_id"]."'>".$value["name"]."</option>";
                                          }
                                        ?>
                                        
                                    </select>
                  <span>Sắp Xếp</span>
                  <select style="height: 30px;" id="select-product-type" onchange="DrawChart()">
                    <option checked value="giam-soluong">Giảm Dần Theo Số Lượng Đã Bán</option>
                    <option value="tang-soluong">Tăng Dần Theo Số Lượng Đã Bán</option>
                    <option checked value="giam-loinhuan">Giảm Dần Theo Doanh Số</option>
                    <option value="tang-loinhuan">Tăng Dần Theo Doanh Số</option>
                  </select>
                  <br>
                  <input type="number" style="width: 50px;" id="chisobanra" name="chisobanra" min="0" onchange="DrawChart()" placeholder="chỉ số bán ra">
                  <label style="cursor: pointer;" for="chisobanra">chỉ hiện mức bán ra theo chỉ sổ bán ra của sản phẩm</label>
                  <!-- <input type="checkbox" id="checkbanra" name="checkbanra" onchange="DrawChart()"> -->
                  <br>
                  <input type="number" style="width: 50px;" id="chisotop" name="chisotop" onchange="DrawChart()" max="20" min="0" placeholder="chỉ số lấy tóp đầu">
                  <label style="cursor: pointer;" for="chisotop">Hiện top bán chạy</label>
                  <input type="checkbox" id="chisotopchecker" name="chisotop" onchange="DrawChart()">
                  <br>
                  <input type="number" style="width: 50px;" id="chisobaodong" name="chisobaodong" onchange="DrawChart()" value="20" placeholder="chỉ số báo động">
                  <label style="cursor: pointer;" for="checksoluong">Hiện Mức Báo Động Kho</label>
                  <input type="checkbox" id="checksoluong" name="checksoluong" onchange="DrawChart()">
                </div>
                  <!-- <p class="d-flex flex-column">
                      <span>Tổng Số Lượng Sản Phẩm Đã Bán Được: </span>
                      <span class="text-bold text-lg soluongdaban">0</span>
                  </p> -->
              </div>
              <div class="card-body table-responsive p-0" style="max-height: 300px;overflow: auto;">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Sản Phẩm</th>
                    <th>Số Lượng Đã Bán</th>
                    <th>Tổng Doanh Thu</th>
                    <th>Số Lượng Tồn Kho</th>
                  </tr>
                  </thead>
                  <tbody style="max-height:500px;" id="thongkesoluongban">
                  </tbody>
                </table>
              </div>
              <h4 class="card-title daban">
              </h4>
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Hóa Đơn</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-bars"></i>
                  </a>
                    <span>Sắp Xếp</span>
                    <select style="height: 30px;" id="select-bill-type" onchange="DrawChart()">
                      <option checked value="bill-by-month">Hiện Tổng Doanh Thu Tháng</option>
                      <option value="bill-by-id">Hiện Tất Cả Hóa Đơn</option>
                    </select>
                </div>
              </div>
              <div style="max-height:400px;overflow: auto;"class="card-body">
              <table class="table table-striped table-valign-middle bill-top">
                  <thead>
                  <tr>
                    <th>Thời Gian Lập Hóa Đơn</th>
                    <th>Số mặt hành được bán ra</th>
                    <th>Tổng Tiền Hóa Đơn</th>
                    <!-- <th>test</th> -->
                  </tr>
                  </thead>
                  <tbody id="bill-scale">
                  </tbody>
                </table>
                <!-- /.d-flex -->
              </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Thương Hiệu</h3>
                </div>
              </div>
              <input onchange="DrawChart()" style="width: 50px;" type="number" name="gettopbrand" id="gettopbrand">
              <label for="checkgettopbrand">chỉ lấy top thương hiệu bán chạy</label>
              <input onchange="DrawChart()" type="checkbox" name="checkgettopbrand" id="checkgettopbrand">
              <div class="card-body">
                <div class="d-flex">
                  <div style="display: flex;" class="d-flex flex-column">
                      <h5>Thương Hiệu Bán Chạy Nhất: </h5>
                      <h5 style="margin-left: 10px; font-weight:bold"  id="bestsalerBrand"></h5>
                  </div>
                  <!-- <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p> -->
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="400"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Last year
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Thương Hiệu</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-tool">
                    <i class="fas fa-bars"></i>
                  </a>
                    <span>Sắp Xếp</span>
                    <select style="height: 30px;" id="select-brand-type" onchange="DrawChart()">
                      <option checked value="giam-loinhuan">Giảm Dần Doanh Số</option>
                      <option value="tang-loinhuan">Tăng Dần Theo Doanh Số</option>
                      <option value="tang-id">Tăng Dần Mã Thương Hiệu</option>
                      <option checked value="giam-id">Giảm Dần Mã Thương Hiệu</option>
                    </select>
                </div>
              </div>
              <div style="max-height:400px;overflow: auto;"class="card-body">
              <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Mã Thương Hiệu</th>
                    <th>Tên Thương Hiệu</th>
                    <th>Tổng Tiền Thương Hiệu</th>
                    <!-- <th>test</th> -->
                  </tr>
                  </thead>
                  <tbody id="thongkehoadon">
                  </tbody>
                </table>
                <!-- /.d-flex -->
              </div>
            </div>

            
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
<script>
  let DoanhThu=[];
  let SoluongDaBan = 0;
  let SoTienDaBan = 0;
  let resultArray=[]; //hóa đơn thời gian
  var amountByProductIdOutput=[];    // sản phẩm số lượng
  var aggregatedBrands = [];
  var maxCheckAmount;
  function geterdate(x) {
    // Chuyển đổi định dạng ngày tháng
    const parts = x.split("-"); // Tách chuỗi theo dấu "-"
    const newDateStr = parts[2] + "-" + parts[1] + "-" + parts[0]; // Gộp lại theo định dạng "dd-mm-yyyy"

    // Hiển thị kết quả
    return newDateStr; // Kết quả là "01-05-2023"
  }
  window.onload = function() {
    $.ajax({
        type: 'POST',
        url: './index.php',
        data:{
            action: "getThongKever2",
        },
        success: function(responseText) {
            resultArray = JSON.parse(responseText).hoadonthoigian;
            amountByProductIdOutput = JSON.parse(responseText).sanpham;
            aggregatedBrands = JSON.parse(responseText).thuonghieu;
            maxCheckAmount = amountByProductIdOutput.reduce((max, item) => Math.max(max, item.amount), 0);
            DrawChart();
        }})
    }
  async function ThongKe(){
    var minday = document.querySelector("#datezoneMin").value;
    var maxday = document.querySelector("#datezoneMax").value;
    await $.ajax({
        type: 'POST',
        url: './index.php',
        data:{
            action: "getThongKever2",
            timer: geterdate(document.querySelector("#datezoneMin").value)+","+geterdate(document.querySelector("#datezoneMax").value),
            typeproduct: document.querySelector("#select-product").value,
            amounter:(document.querySelector("#chisobanra").value==""||document.querySelector("#chisobanra").value==0)?"":document.querySelector("#chisobanra").value,
            limit: ''
        },
        success: function(responseText) {
            // var resultArray = [{monthyear: '04-2023', price: 34145000, countbill: 1},{monthyear: '05-2023', price: 3416000, countbill: 1}];
            resultArray = JSON.parse(responseText).hoadonthoigian;
            amountByProductIdOutput = JSON.parse(responseText).sanpham;
            aggregatedBrands = JSON.parse(responseText).thuonghieu;
            maxCheckAmount = amountByProductIdOutput.reduce((max, item) => Math.max(max, item.amount), 0);
            // DrawChart();
        }})
  }
  let today = new Date();
  let year = today.getFullYear();
  let month = today.getMonth() + 1;
  let day = today.getDate();

if (month < 10) {
  month = '0' + month;
}

if (day < 10) {
  day = '0' + day;
}

let todayes = year + '-' + month + '-' + day;
document.querySelector("#datezoneMax").value = todayes;
document.querySelector("#datezoneMin").value = year+"-01-01";
  

  function getValueChart(){
    
  }
  async function DrawChart(){
    await ThongKe();
    SoTienDaBan = 0;
    const filteredData = {};
    SoluongDaBan=0;
    const core = DoanhThu;
    const daymax = document.querySelector("#datezoneMax").value;
    const daymin = document.querySelector("#datezoneMin").value;
    // document.querySelector("#chisobanra").value = parseInt(maxCheckAmount)



    let ctx = document.getElementById('visitors-chart').getContext('2d');
    //biến doanh thu theo thời gian
    console.log(resultArray);
    // resultArray = []; //lập trạng thái giả dữ liệu không có
        // Tạo biểu đồ
    let labels = resultArray.map(item => item.monthyear);
    let data = resultArray.map(item => item.price);
    var oldChart = Chart.getChart("visitors-chart");
    // Xóa Biểu Đồ Cũ
    if (oldChart) {
      oldChart.destroy();
    }
    oldChart = Chart.getChart("sales-chart");
    if (oldChart) {
      oldChart.destroy();
    }
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Doanh thu theo thời gian',
          data: data,
          borderColor: '#0070C0',
          backgroundColor: '#0070C0',
          fill: false
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value, index, values) {
                return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
              }
            }
          }
        }
      }
    });

    
    document.querySelector("#thongkesoluongban").innerHTML="";
    switch (document.getElementById("select-product").value) {
      case "all":
        break;
      default:
      amountByProductIdOutput = amountByProductIdOutput.filter(item => parseInt(item.product_type_id) == document.getElementById("select-product").value)
        break;
    }
    DoanhThu.forEach(element => {
              SoTienDaBan+=parseInt(element.total)
    });
    switch (document.getElementById("select-product-type").value) {
      case "tang-soluong":
        amountByProductIdOutput.sort((a, b) => parseInt(a.amount) - parseInt(b.amount));
        break;
      case "giam-soluong":
        amountByProductIdOutput.sort((a, b) => parseInt(b.amount) - parseInt(a.amount));
        break;
      case "tang-loinhuan":
        amountByProductIdOutput.sort((a, b) => parseInt(a.price) - parseInt(b.price));
        break;
      case "giam-loinhuan":
        amountByProductIdOutput.sort((a, b) => parseInt(b.price) - parseInt(a.price));
        break;
    }
    temp = 0
    console.log(amountByProductIdOutput)
    if(document.getElementById("checksoluong").checked){
      amountByProductIdOutput = amountByProductIdOutput.filter(item => {
        return parseInt(item.soluongton)<=document.getElementById("chisobaodong").value;
      })
    }
    if(document.getElementById("chisotopchecker").checked&&document.getElementById("chisotop").value>0)
      amountByProductIdOutput=amountByProductIdOutput.slice(0,document.getElementById("chisotop").value)
amountByProductIdOutput.forEach((element,index) => {
    temp +=parseInt(element.price);

    document.querySelector("#thongkesoluongban").innerHTML+=`
    <tr>
                      <td>
                        <img style="max-width: 30px;max-height: 30px;object-fit: cover;" src="${element.img}" alt="Product" class="img-circle img-size-32 mr-2">
                        ${element.name_sp}
                      </td>
                      <td>
                        ${element.amount} Sold
                      </td>
                      <td>`+parseInt(element.price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })+`</td>
                      <td>
                        <span class=" `+ (parseInt(element.soluongton)>20? "text-success" : "text-danger") +`">
                            ${element.soluongton}
                        </span>

                      </td>
                    </tr>
    `

  });

  document.querySelector(".daban").innerHTML = "Tổng số doanh thu: "+parseInt(temp).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
  document.querySelector(".sotiendaban").innerHTML = parseInt(temp).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });

  if(document.getElementById("gettopbrand").value!="" && document.getElementById("checkgettopbrand").checked)
      aggregatedBrands=aggregatedBrands.slice(0,document.getElementById("gettopbrand").value)
      // var aggregatedBrands = []; // lập trạng thái dữ liệu không có
      labels = aggregatedBrands.map(item => item.name_brand);
      values = aggregatedBrands.map(item => item.total);
      const highestTotalBrand = aggregatedBrands.reduce((acc, cur) => parseInt(cur.total) > parseInt(acc.total) ? cur : acc).name_brand;
      document.getElementById("bestsalerBrand").innerHTML=highestTotalBrand
      ctx = document.getElementById('sales-chart').getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            label: 'Doanh thu theo thương hiệu',
            data: values,
            backgroundColor: [
              'rgba(255, 99, 132, 0.5)',
              'rgba(54, 162, 235, 0.5)',
              'rgba(255, 206, 86, 0.5)',
              'rgba(75, 192, 192, 0.5)',
              'rgba(153, 102, 255, 0.5)',
              'rgba(255, 159, 64, 0.5)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            },
            title: {
              display: true,
              text: 'Doanh thu theo thương hiệu'
            }
          }
        }
      });

      switch (document.getElementById("select-brand-type").value) {
      case "tang-id":
        aggregatedBrands.sort((a, b) => parseInt(a.id_brand) - parseInt(b.id_brand));
        break;
      case "giam-id":
        aggregatedBrands.sort((a, b) => parseInt(b.id_brand) - parseInt(a.id_brand));
        break;
      case "tang-loinhuan":
        aggregatedBrands.sort((a, b) => parseInt(a.total) - parseInt(b.total));
        break;
      case "giam-loinhuan":
        aggregatedBrands.sort((a, b) => parseInt(b.total) - parseInt(a.total));
        break;
    }
      document.querySelector("#thongkehoadon").innerHTML = "";
      console.log(aggregatedBrands)
      aggregatedBrands.forEach(element => {
        const total = parseInt(element.total).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })
        document.querySelector("#thongkehoadon").innerHTML+=`
        <tr>
          <td>${element.brand_id}</td>
          <td>${element.name_brand}</td>
          <td>${total}</td>
          
        </tr>
       `
      });
        //vẽ bill sơ đồ
    switch (document.querySelector("#select-bill-type").value) {
      case "bill-by-month":
        document.querySelector("#bill-scale").innerHTML=''
        resultArray.forEach(element => {
          document.querySelector("#bill-scale").innerHTML+=`
                  <tr>
                    <td>${element.monthyear}</td>
                    <td>${parseInt(element.countbill)}</td>
                    <td>${parseInt(element.price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</td>
                  </tr>
          `;
        });
        break;
      case "bill-by-id":
        document.querySelector("#bill-scale").innerHTML=''
        resultArray.forEach(element => {
          document.querySelector("#bill-scale").innerHTML+=`
            bill
          `;
        });
        break;
      default:
        break;
    }
  }
// lgtm [js/unused-local-variable]
</script>