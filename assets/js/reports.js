/*=========================================
REPORTS
=========================================*/

document.addEventListener("DOMContentLoaded", () => {

  if (typeof reportData === "undefined") {

      return;

  }

  /*=========================================
  STATUS CHART
  =========================================*/

  const statusCanvas = document.getElementById("statusChart");

  if (statusCanvas) {

      const statusLabels = reportData.status.map(item => item.status);

      const statusTotals = reportData.status.map(item => item.total);

      new Chart(statusCanvas, {

          type: "doughnut",

          data: {

              labels: statusLabels,

              datasets: [{

                  data: statusTotals,

                  backgroundColor: [

                      "#F59E0B",
                      "#3B82F6",
                      "#10B981",
                      "#6B7280"

                  ]

              }]

          },

          options: {

              responsive: true,

              maintainAspectRatio: false,

              plugins: {

                  legend: {

                      position: "bottom"

                  }

              }

          }

      });

  }

  /*=========================================
  CATEGORY CHART
  =========================================*/

  const categoryCanvas = document.getElementById("categoryChart");

  if (categoryCanvas) {

      const categoryLabels = reportData.category.map(item => item.category);

      const categoryTotals = reportData.category.map(item => item.total);

      new Chart(categoryCanvas, {

          type: "bar",

          data: {

              labels: categoryLabels,

              datasets: [{

                  label: "Complaints",

                  data: categoryTotals,

                  backgroundColor: "#2563EB"

              }]

          },

          options: {

              responsive: true,

              maintainAspectRatio: false,

              scales: {

                  y: {

                      beginAtZero: true,

                      ticks: {

                          precision: 0

                      }

                  }

              },

              plugins: {

                  legend: {

                      display: false

                  }

              }

          }

      });

  }

  /*=========================================
  PRIORITY CHART
  =========================================*/

  const priorityCanvas = document.getElementById("priorityChart");

  if (priorityCanvas) {

      const priorityLabels = reportData.priority.map(item => item.priority);

      const priorityTotals = reportData.priority.map(item => item.total);

      new Chart(priorityCanvas, {

          type: "pie",

          data: {

              labels: priorityLabels,

              datasets: [{

                  data: priorityTotals,

                  backgroundColor: [

                      "#10B981",
                      "#FACC15",
                      "#F97316",
                      "#DC2626"

                  ]

              }]

          },

          options: {

              responsive: true,

              maintainAspectRatio: false,

              plugins: {

                  legend: {

                      position: "bottom"

                  }

              }

          }

      });

  }

  /*=========================================
  MONTHLY CHART
  =========================================*/

  const monthlyCanvas = document.getElementById("monthlyChart");

  if (monthlyCanvas) {

      const monthlyLabels = reportData.monthly.map(item => item.month);

      const monthlyTotals = reportData.monthly.map(item => item.total);

      new Chart(monthlyCanvas, {

          type: "line",

          data: {

              labels: monthlyLabels,

              datasets: [{

                  label: "Complaints",

                  data: monthlyTotals,

                  borderColor: "#2563EB",

                  backgroundColor: "rgba(37,99,235,0.15)",

                  fill: true,

                  tension: 0.3

              }]

          },

          options: {

              responsive: true,

              maintainAspectRatio: false,

              scales: {

                  y: {

                      beginAtZero: true,

                      ticks: {

                          precision: 0

                      }

                  }

              },

              plugins: {

                  legend: {

                      position: "bottom"

                  }

              }

          }

      });

  }

});