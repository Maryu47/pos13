<template>
    <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body">

    <div v-if="ShowForm">
        <div class=" d-flex justify-content-end">
            <button type="button" class="btn btn-success me-2" @click="SaveStore()" :disabled="CheckForm" >ບັນທຶກ</button>
            <button type="button" class="btn btn-secondary" @click="CancelStore()">ຍົກເລີກ</button>
        </div>
        <!-- {{ FormStore }}
        <hr> -->
        <div class="row">
            <div class=" col-md-4 text-center" style=" position: relative;">
              <button type="button" class="btn rounded-pill btn-icon btn-danger" v-if="FormStore.image" @click="RemoveImage()" style="position: absolute;right: 0px;">
                <i class='bx bxs-x-circle fs-4'></i>
              </button>
              <img :src="image_pre" class=" rounded cursor-pointer" @click="$refs.img_store.click()" style=" width: 80%;" alt="">
              <input type="file" ref="img_store" style=" display: none;" @change="onSelect">
            </div>
            <div class=" col-md-8"> 

                <div>
          <label  class="form-label fs-6">ຊື່ສິນຄ້າ: <span class="text-danger">*</span></label>
          <input type="text" class="form-control mb-2" v-model="FormStore.name"  placeholder=".....">
          <label  class="form-label fs-6">ຈຳນວນ: <span class="text-danger">*</span></label>
          <cleave :options="options" class="form-control mb-2" v-model="FormStore.amount" placeholder="....."/>
                    
          <div class="row">
            <div class="col-md-6">
                <label  class="form-label fs-6">ລາຄາຊື້: <span class="text-danger">*</span></label>
                <cleave :options="options" class="form-control mb-2" v-model="FormStore.price_buy"  placeholder="....."/>
            </div>
            <div class="col-md-6">
                <label  class="form-label fs-6">ລາຄາຂາຍ: <span class="text-danger">*</span></label>
                <cleave :options="options"  class="form-control mb-2" v-model="FormStore.price_sell"  placeholder="....."/>
            </div>
          </div>
        </div>

            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!ShowForm">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
                <div class=" me-2 cursor-pointer" @click="ChangeSort()"> 
                    <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                    <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
                </div>
                <select  class=" form-select" v-model="PerPage" @change="GetStore()">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class=" d-flex">
                <input type="text" class=" form-control me-2" v-model="Search" @keyup.enter="GetStore()" placeholder="ຄົ້ນຫາ...">
                <button type="button" class="btn btn-primary" @click="AddStore()"> <i class='bx bxs-user-plus me-2 fs-4'></i> ເພີ່ມໃໝ່</button>
            </div>
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="70">ID</th>
            <th width="120" class=" text-center">ຮູບພາບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th width="180" class=" text-center">ລາຄາຊື້</th>
            <th width="80" class=" text-center">ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData.data" :key="list.id">
            <td> {{ list.id }} </td>
            <td> 
              
              <img :src="url + '/assets/img/'+list.image" v-if="list.image" style=" width: 100%;" class=" rounded" alt="">
              <img :src="url + '/assets/img/image_pre.png'" v-else style=" width: 100%;" class=" rounded" alt="">
            </td>
            <td>
                {{ list.name }}
            </td>
            <td class=" text-end">{{ formatPrice(list.price_buy) }} ກີບ</td>
            <td class=" text-center">
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);" @click="EditStore(list.id)"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="DeleteStore(list.id)"><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>
          
        </tbody>
      </table>
      <Pagination :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />
      <button @click="showAlert">Hello world</button>
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';
import { useStore } from '../store/auth';
import Cleave from 'vue-cleave-component';
export default {
    name: 'Minipos13Store',
    setup(){
      const store = useStore();
      return { store }
    },
    data() {
        return {
        url: window.location.origin,
        image_pre: window.location.origin + '/assets/img/image_pre.png',
        ShowForm:false,
        FormType:true,
        Sort:'asc',
        PerPage:'5',
        Search:'',
        EditID:'',
         StoreData:[],
         FormStore:{
            name:'',
            image:'',
            amount:'',
            price_buy:'',
            price_sell:'',
         },
         options: {
                   //   prefix: '₭ ',
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: ',',
                  delimiter: '.'
                }   
        };
    },

    mounted() {
        
    },
    components:{
      Cleave
    },
    computed:{
        CheckForm(){
            if(this.FormStore.name == '' || this.FormStore.amount == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell ==''){
                return true
            } else {
                return false
            }
        }
    },

    methods: {
      onSelect(event){
        // console.log(event)
        this.FormStore.image = event.target.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(this.FormStore.image);
        reader.addEventListener("load", function(){
          this.image_pre = reader.result;
        }.bind(this), false);

      },
      RemoveImage(){
        this.FormStore.image = ''
        this.image_pre = window.location.origin + '/assets/img/image_pre.png'
      },
      formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
      showAlert() {
      // Use sweetalert2
      // this.$swal('Hello Vue world!!!');

      // this.$swal({
      //   position: 'top-end',
      //    toast: true,
      //     title: "The Internet?",
      //     icon: "success",
      //     showConfirmButton: false,
      //     timer: 2500
      //   });

        this.$swal({
        // position: 'top-end',
        //  toast: true,
          title: "The Internet?",
          icon: "error",
          showConfirmButton: false,
          timer: 3500
        });
    },
      ChangeSort(){
          if(this.Sort == 'asc'){
            this.Sort = 'desc'
          } else {
            this.Sort = 'asc'
          }
          this.GetStore()
      },
        AddStore(){

            this.FormStore.name = ''
            this.FormStore.image = ''
            this.FormStore.amount = '' 
            this.FormStore.price_buy = ''
            this.FormStore.price_sell = ''

            this.image_pre = this.url + '/assets/img/image_pre.png'

            this.ShowForm = true
            this.FormType = true
        },
        CancelStore(){
            this.ShowForm = false
        },
        EditStore(id){
            this.FormType = false
            this.EditID = id

            axios.get(`api/store/edit/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{

              this.FormStore = res.data 
              this.ShowForm = true

              // ກວດຊອບຮູບພາບ ເພື່ອດຶງໄປສະແດງຜົນ
              if(res.data.image){
                this.image_pre = this.url + '/assets/img/' + res.data.image
              } else {
                this.image_pre = this.url + '/assets/img/image_pre.png'
              }

            }).catch((error)=>{
              console.log(error)

              if (error.response.status == 401) {
                    this.store.remove_token();
                    this.store.remove_user();
                    localStorage.removeItem("web_token");
                    localStorage.removeItem("web_user");
                    this.$router.push("/login")
                }   

            })

        },
        DeleteStore(id){


            this.$swal({
                  title: "ທ່ານແນ່ໃຈບໍ່?",
                  text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "ຕົກລົງ!",
                  cancelButtonText: "ຍົກເລີກ"
                }).then((result) => {
                  if (result.isConfirmed) {


                    axios.delete(`api/store/delete/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{

                          if(res.data.success){
                            this.GetStore()
                              this.$swal({
                                title: "ການລຶບຂໍ້ມູນ!",
                                text: res.data.message,
                                icon: "success"
                              });
                          } else {
                            this.$swal({
                          // position: 'top-end',
                          //  toast: true,
                            title: res.data.message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3500
                          });
                          }

                        }).catch((error)=>{
                          console.log(error)

                          if (error.response.status == 401) {
                            this.store.remove_token();
                            this.store.remove_user();
                            localStorage.removeItem("web_token");
                            localStorage.removeItem("web_user");
                            this.$router.push("/login")
                        }   

                        })
                  }
                });

            
        },
        SaveStore(){

                if(this.FormType){
                    /// add new

                    axios.post('api/store/add', this.FormStore,{ headers:{ "content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{
                        console.log(res.data);
                        if(res.data.success){
                          this.GetStore()
                           this.ShowForm = false 
                           this.$swal({
                            position: 'top-end',
                            toast: true,
                              title: res.data.message,
                              icon: "success",
                              showConfirmButton: false,
                              timer: 2500
                            });

                        } else {

                          this.$swal({
                          // position: 'top-end',
                          //  toast: true,
                            title: res.data.message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3500
                          });

                        }

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

                } else {
                    /// update data

                    axios.post(`api/store/update/${this.EditID}`, this.FormStore,{ headers:{ "content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{

                        console.log(res.data);

                        if(res.data.success){
                          this.GetStore()
                          this.ShowForm = false 

                          this.$swal({
                            position: 'top-end',
                            toast: true,
                              title: res.data.message,
                              icon: "success",
                              showConfirmButton: false,
                              timer: 2500
                            });

                        } else {
                          this.$swal({
                          // position: 'top-end',
                          //  toast: true,
                            title: res.data.message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3500
                          });
                        }

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
        GetStore(page){

            axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&search=${this.Search}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((res)=>{{

              this.StoreData = res.data

            }}).catch((error)=>{
              console.log(error)

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

<style lang="scss" scoped>

</style>