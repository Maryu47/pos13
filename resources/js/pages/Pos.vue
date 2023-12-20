<template>
    <div class="row">

        <div class="col-md-8">
            <div class="card mb-2">
                <div class="card-body">
                    <input type="text" class=" form-control" placeholder="ຄົ້ນຫາ..." @keyup.enter="GetStore()" v-model="Search">
                </div>
            </div>
            <div class=" row" style=" overflow: auto; height: 66vh;">
                <div class="col-md-3" v-for="list in StoreData.data" :key="list.id">
                    <div class="card mb-3 cursor-pointer" @click="AddProduct(list.id)">
                        <span v-for="item in ListOrder" :key="item.id">
                            <span class="num-pos" v-if="list.id == item.id">{{ item.order_amount }}</span>
                        </span>
                        
                    <img :src="url + '/assets/img/'+list.image" v-if="list.image" class=" card-img-top img-pos" alt="">
                    <img :src="url + '/assets/img/image_pre.png'" v-else  class=" card-img-top img-pos" alt="">

                    <div class="card-body p-1 text-center ">
                        {{ list.name }}
                        <p class="card-text">
                        {{ formatPrice(list.price_sell) }} ກີບ
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style=" overflow: auto; height: 79vh;">
                <div class="card-body">
                    <label for="">ຊື່ສິນຄ້າ:</label>
                    <input type="text" class=" form-control mb-2" placeholder="...">
                    <label for="">ເບີໂທ:</label>
                    <input type="text" class=" form-control" placeholder="...">
                    <hr>
                    <div class=" d-flex justify-content-between fs-4 text-info fw-bold">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                    </div>
                    <button class=" btn btn-info w-100 fs-5 fw-bold mb-2" :disabled="!TotalAmount" @click="Pay()">ຊຳລ່ະເງິນ</button>

                    <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ລາຍການ</th>
            <th>ລາຄາ</th>
            <th>ຍອດລວມ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in ListOrder" :key="item.id">
            <td>{{ item.name }}</td>
            <td>{{ formatPrice(item.price_sell) }} <br> 
                <i class='bx bxs-minus-circle text-warning cursor-pointer' @click="RemoveProduct(item.id)"></i>  {{ item.order_amount }} <i class='bx bxs-plus-circle text-info cursor-pointer' @click="AddProduct(item.id)"></i> |  <i class='bx bxs-x-circle text-danger cursor-pointer' @click="DeleteProduct(item.id)"></i>
            </td>
            <td>{{ formatPrice(item.price_sell*item.order_amount) }}</td>
          </tr>
          

        </tbody>
      </table>
    </div>
                </div>
            </div>
        </div>
        
    </div>

    <div class="modal fade" id="dialog_pay" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">ການຊຳລ່ະເງິນ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class=" d-flex justify-content-between">
                    <span>ລວມຍອດເງິນ:</span>
                    <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                  </div>
                  <div class=" d-flex justify-content-between">
                    <span>ຮັບເງິນນຳລູກຄ້າ:</span>
                    <span>{{ formatPrice(CashAmount) }} ກີບ</span>
                  </div>
                  <div class=" d-flex justify-content-between text-danger" v-if="(CashAmount-TotalAmount)>0">
                    <span>ເງິນທອນ:</span>
                    <span>{{ formatPrice(CashAmount - TotalAmount) }} ກີບ</span>
                  </div>

                  <div class=" d-flex justify-content-center">
                    <div class="row" style=" width: 250px; ">
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(1)" >1</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(2)" >2</button>
                </div>
                <div class=" col-md-4 mt-2"> 
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(3)" >3</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(4)" >4</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(5)" >5</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(6)" >6</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(7)" >7</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(8)" >8</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(9)" >9</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum('00')" >00</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-primary" style=" width: 60px;" @click="AddNum(0)" >0</button>
                </div>
                <div class=" col-md-4 mt-2">
                    <button class="btn btn-danger" style=" width: 60px;" @click="AddNum('-')" ><i class='bx bx-left-arrow-alt'></i></button>
                </div>


            </div>
                  </div>

                </div>
                <div class="modal-footer">
                  
                  <button type="button" class="btn btn-primary">ຍືນຍັນຊຳລ່ະເງິນ</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
                </div>
              </div>
            </div>
          </div>
</template>

<script>
import axios from 'axios';
import { useStore } from '../store/auth';
export default {
    name: 'Minipos13Pos',
    setup(){
      const store = useStore();
      return { store }
    },
    data() {
        return {
            url: window.location.origin,
        Sort:'asc',
        PerPage:'30',
        Search:'',
        StoreData:[],
        ListOrder:[],
        CashAmount:''
        };
    },

    mounted() {
        
    },
    computed:{
        TotalAmount(){
            let calculate = this.ListOrder.reduce((num,item)=> parseInt(num) + (parseInt(item.order_amount) * parseInt(item.price_sell)),0);
            return calculate;
        }
    },

    methods: {
        AddNum(num){
            if(num == '-'){
                this.CashAmount = this.CashAmount.slice(0,-1); // 120 = 12
            } else {
                this.CashAmount = this.CashAmount + num; // 1 + 2 = 12 /// 3
            }
        },
        Pay(){
            $("#dialog_pay").modal("show");
        },
        AddProduct(id){
            let item = this.StoreData.data.find((i)=>i.id == id);

            if(item.amount>0){

                let list_order_item = this.ListOrder.find((i)=>i.id == id); 

                if(list_order_item){

                    if((item.amount - list_order_item.order_amount)>0){
                        list_order_item.order_amount++;
                    } else {
                        this.$swal({
                            title: "ບໍ່ສາມາດຂາຍໄດ້!",
                            text:"ສິນຄ້າດັ່ງກ່າວໝົດແລ້ວ!",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3500
                          });
                    }
                    
                } else {
                    // ເພີ່ມຂໍ້ມູນເຂົ້າໄປ ListOrder
                    this.ListOrder.push({
                        id: item.id,
                        name: item.name,
                        order_amount: 1,
                        price_sell: item.price_sell
                    });
                }


            } else {
                this.$swal({
                            title: "ບໍ່ສາມາດຂາຍໄດ້!",
                            text:"ສິນຄ້າດັ່ງກ່າວໝົດແລ້ວ!",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3500
                          });
            }

                
            

        },
        RemoveProduct(id){

            let list_order = this.ListOrder.find((i)=>i.id == id)
            if(list_order){
                list_order.order_amount--;
                if(list_order.order_amount<1){
                    this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1);
                }
            }

        },
        DeleteProduct(id){
            this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1);
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        GetStore(page){

            axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{{

            this.StoreData = res.data

            }}).catch((error)=>{
            console.log(error)
            })
            }
    },
    created(){
        this.GetStore()
    },
    watch:{
      Search(){
        if(this.Search == ''){
          this.GetStore()
        }
      }
    }
};
</script>

<style scoped>

    .img-pos{
        width: 100%;
        height: 125px;
        object-fit: cover;
        object-position: center;
    }

    .num-pos{
        position: absolute;
        background-color: blue;
        color: white;
        padding: 4px;
        font-weight: bolder;
        right: 0px;
        border-radius: 0px 8px 0px 8px;
    }

</style>