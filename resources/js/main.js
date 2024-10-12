/*----------
ダッシュボードの設定
----------*/
import Chart, { Ticks } from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {
  var tableBody = document.getElementById('latestProposalsTable').querySelector('tbody');

  // chartDataが定義されているか確認
  if (typeof chartData !== 'undefined') {
    // テーブル行を生成
    chartData.forEach(function (item) {
      var row = document.createElement('tr');

      var cellDate = document.createElement('td');
      cellDate.className = 'border px-4 py-2';
      cellDate.textContent = item.date;
      row.appendChild(cellDate);

      var cellName = document.createElement('td');
      cellName.className = 'border  px-4 py-2';
      cellName.textContent = item.name; // 仮にnameフィールドが存在する場合
      row.appendChild(cellName);

      var cellTitle = document.createElement('td');
      cellTitle.className = 'border px-4 py-2';
      cellTitle.textContent = item.title;
      row.appendChild(cellTitle);

      tableBody.appendChild(row);
    });
  }
});

// 個人投稿別グラフの作成
console.log(mvp);
console.log(mvp[0].postCount);
let barCtx = document.getElementById('mvp_chart');
  let barConfig = {
   type: 'bar',
    data: {
      labels:  [mvp[0].name,mvp[1].name,mvp[2].name,mvp[3].name,mvp[4].name],
      datasets: [{
        data: [mvp[0].postCount,mvp[1].postCount,mvp[2].postCount,mvp[3].postCount,mvp[4].postCount],
        label: "件数",
        backgroundColor: [  // それぞれの棒の色を設定(dataの数だけ)
         '#8BD1FF',
          '#8BD1FF',
          '#8BD1FF',
          '#8BD1FF',
          '#8BD1FF',
          '#8BD1FF',
        ],
        borderWidth: 1,
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks:{
            min: 0,
            stepSize: 1
          }
        }
      }
    }
  };
let barChart = new Chart(barCtx, barConfig);
  
// 部署別提案件数グラフの作成
console.log(dpt);
console.log(dpt[0].postCount);
let deptCtx = document.getElementById('department_chart');
let labels =  ['生産技術部', '研究開発部', '経理部', '営業部'];
let backgroundColors =[];
console.log(belong);

for(let i = 0; i<labels.length;i++){
  if(belong != labels[i]){
    backgroundColors[i] = "#8BD1FF";
  }else{
    backgroundColors[i] = "#0099FF";
  }
}

let deptConfig = {
  type: 'bar',
  data: {
    labels: ['生産技術部', '研究開発部', '経理部', '営業部'],
    datasets: [{
      data: [dpt[0].proposalCount, dpt[1].proposalCount, dpt[2].proposalCount, dpt[3].proposalCount ],
      label: "件数",
      backgroundColor: backgroundColors,
      borderWidth: 1,
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        ticks:{
          min: 0,
          stepSize: 1
        }
      }
    }
  }
};
let deptChart = new Chart(deptCtx, deptConfig);


