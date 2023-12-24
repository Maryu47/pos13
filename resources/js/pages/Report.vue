<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
  <h5 class="card-header">ລາຍງານ</h5>
  <div class="card-body">
    <div class="table-responsive text-nowrap">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
            
            </div>
            <div class=" d-flex me-2">
                <div class="btn-group me-2" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary" @click="month_type='m'" ><i class='bx bx-chevron-right' v-if="month_type=='m'"></i>ເດຶອນ</button>
                <button type="button" class="btn btn-secondary" @click="month_type='y'"><i class='bx bx-chevron-right'  v-if="month_type=='y'"></i>ປີ</button>
                </div>
                <input type="date" class=" form-control" v-model="dmy">
            </div>
        </div>
        <LineChart :chart-data="chData" :options="choption" />
    </div>
  </div>
</div>
        </div>
        <div class="col-md-4">Widget</div>
    </div>
</template>

<script>
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);
import axios from 'axios';
import { useStore } from '../store/auth';
export default {
    name: 'Minipos13Report',
    setup(){
      const store = useStore();
      return { store }
    },

    data() {
        return {
            month_type:'m',
            dmy: new Date().toISOString().slice(0,10),
            chData:[],
            choption:{
                plugins:{
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                            return (
                                Number(tooltipItem.raw) .toFixed(0) .replace(/./g, function (c, i, a) { return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c; }) + " ກີບ" );
                            },
                        },
                        mode: "index",
                        intersect: false,
                        },
                    
                },
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                        y:{
                        ticks: {
                            display: true,
                            beginAtZero: false,
                            callback: function (value, index, values) {
                            return ( Number(value) .toFixed(0) .replace(/./g, function (c, i, a) { return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c; }) + " ກີບ" );
                            },
                        },
                        gridLines: {
                            show: true,
                        },
                        },
                    },
                    
            }
        };
    },
    components:{
        LineChart
    },  

    mounted() {
        
    },

    methods: {
        CreateReport(){
            
            axios.post('api/report', {
                month_type:this.month_type,
                dmy:this.dmy,
            }, { headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{



            }).catch((error)=>{
                console.log(error);

                if (error.response.status == 401) {
                    this.store.remove_token();
                    this.store.remove_user();
                    localStorage.removeItem("web_token");
                    localStorage.removeItem("web_user");
                    this.$router.push("/login")
                }  
            })
        }
    },
    created(){
        this.CreateReport()
    },
    watch:{
        dmy(){
            this.CreateReport();
        },
        month_type(){
            this.CreateReport();
        }
    },
};
</script>

<style lang="scss" scoped>

</style>