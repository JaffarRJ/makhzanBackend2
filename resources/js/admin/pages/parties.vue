<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0"><Button @click="addModal=true"><Icon type="md-add" /> Add Party</Button></p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>CNIC</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(items, i) in setData" :key="i" v-if="setData.length">
                                <td>{{items.id}}</td>
                                <td class="_table_name">{{items.name}}</td>
                                <td>{{items.cnic}}</td>
                                <td>{{items.phone}}</td>
                                <td>{{items.address}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(items, i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeletingModal(items, i)"  :loading="items.isDeleting">Delete</Button>
                                    <Button type="success" size="small" @click="showStatusesModal(items, i)">{{items.is_active == 1 ? 'Active' : 'Deactive'}}</Button>
                                    <Button type="warning" size="small" @click="showShowsModal(items, i)">{{items.is_show == 1 ? 'Showing' : 'Not Showing'}}</Button>

                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>

                <!-- adding modal -->
                <Modal v-model="addModal" title="Add Party" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Input type="text" v-model="data.name" placeholder="Full Name" autocomplete="off" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.cnic" placeholder="CNIC" autocomplete="off" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="data.phone" placeholder="Phone Number" autocomplete="off" />
                    </div>
                    <div class="space">
                        <textarea type="text" class="form-control" v-model="data.address" placeholder="Address" autocomplete="off" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addItem" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Account'}}</Button>
                    </div>

                </Modal>
                <!-- editing modal -->
                <Modal v-model="editModal" title="Edit Party" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Input type="text" v-model="editData.name" placeholder="Full name"  />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.cnic" placeholder="CNIC" autocomplete="off" />
                    </div>
                    <div class="space">
                        <Input type="text" v-model="editData.phone" placeholder="Phone Number" autocomplete="off" />
                    </div>
                    <div class="space">
                        <textarea type="text" class="form-control" v-model="editData.address" placeholder="Address" autocomplete="off" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editItem" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Party'}}</Button>
                    </div>
                </Modal>
                <!-- delete alert modal -->
                <Modal v-model="showDeleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to delete?.</p>

                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleing" :disabled="isDeleing" @click="deleteItemBtn" >Delete</Button>
                    </div>
                </Modal>
                <!-- show alert modal -->
                <Modal v-model="showStatusModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Change Status</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to change status?.</p>

                    </div>
                    <div slot="footer">
                        <Button type="success" size="large" long :loading="isStatus" :disabled="isStatus" @click="statusItemBtn">Change Status</Button>
                    </div>
                </Modal>
                <!-- show alert modal -->
                <Modal v-model="showShowModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Change Showing</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to Showing or Not?.</p>
                    </div>
                    <div slot="footer">
                        <Button type="success" size="large" long :loading="isStatus" :disabled="isStatus" @click="showItemBtn">Show or Not</Button>
                    </div>
                </Modal>

            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data(){
            return {
                data : {
                    name: '',
                    cnic: '',
                    phone: '',
                    address: '',
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                setData : [],
                editData : {
                    name: '',
                    cnic: '',
                    phone: '',
                    address: ''
                },
                index : -1,
                showDeleteModal: false,
                showStatusModal: false,
                showShowModal: false,
                isDeleing : false,
                isStatus : false,
                isShow: false,
                deleteItem: {},
                statusItem: {},
                deletingIndex: -1,
                websiteSettings: [],

            }
        },

        methods : {
            async addItem(){
                if(this.data.name.trim()=='') return this.e('Name is required')
                if(this.data.cnic.trim() =='') return this.e('CNIC is required')
                if(this.data.phone.trim()=='') return this.e('Phone Number is required')
                if(this.data.address.trim()=='') return this.e('Address is required')

                const res = await this.callApi('post', 'api/party/store', this.data)
                if(res.status===200){
                    const setItemData = res.data.data;
                    // this.setData.unshift(setItemData);
                    this.s('Party has been added successfully!');
                    this.addModal = false;
                    this.data.name = '';
                    this.data.detail = '';
                    window.location.reload();
                }else{
                    if(res.status==422){
                        for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
                    }else{
                        this.swr()
                    }
                }
            },
            async editItem(){
                if(this.editData.name.trim()=='') return this.e('Name is required')
                if(this.editData.cnic.trim()=='') return this.e('CNIC is required')
                if(this.editData.phone.trim()=='') return this.e('Phone Number is required')
                if(this.editData.address.trim()=='') return this.e('Address is required')
                const res = await this.callApi('post', 'api/party/update', this.editData)
                if(res.status===200){
                    this.setData[this.index] = this.editData;
                    this.s('Items has been edited successfully!')
                    this.editModal = false;
                }else{
                    if(res.status==422){
                        for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
                    }else{
                        this.swr()
                    }
                }
            },
            showEditModal(items, index){
                let obj = {
                    id : items.id,
                    name : items.name,
                    cnic : items.cnic,
                    phone : items.phone,
                    address : items.address
                }
                this.editData = obj;
                this.editModal = true;
                this.index = index
            },
            async deleteItemBtn(){
                this.isDeleing = true;
                const res = await this.callApi('post', 'api/party/delete', this.deleteItem)
                if(res.status===200){
                    this.setData.splice(this.deleteItem,1)
                    this.s('Items has been deleted successfully!')
                }else{
                    this.swr()
                }
                this.isDeleing = false
                this.showDeleteModal = false

            },
            async statusItemBtn(){
                this.isStatus = true;
                const setIsActive = {'id':this.statusItem.id};
                const res = await this.callApi('post', 'api/party/updateIsActive', setIsActive)
                if(res.status===200){
                    // this.setData.splice(this.statusItem,1)
                    window.location.reload();

                    this.s('Items Status Change successfully!')
                }else{
                    this.swr()
                }
                this.isShow = false;
                this.showStatusModal = false;

            },async showItemBtn(){
                this.isStatus = true;
                const setIsShow = {'id':this.showItem.id};
                const res = await this.callApi('post', 'api/party/updateIsShow', setIsShow)
                if(res.status===200){
                    // this.setData.splice(this.statusItem,1)
                    window.location.reload();

                    this.s('Showing Status Change successfully!')
                }else{
                    this.swr()
                }
                this.isShow = false;
                this.showStatusModal = false;

            },
            showDeletingModal(items, i){
                this.deleteItem = items,
                    this.showDeleteModal =  true
            },
            showStatusesModal(items, i) {
                this.statusItem = items,
                    this.showStatusModal = true
            },
            showShowsModal(items, i){
                this.showItem = items,
                    this.showShowModal =  true
            }
        },

        async created(){
            const [res, resRole] = await Promise.all([
                this.callApi('get', 'api/party/listing'),
                // this.callApi('get', 'api/role/role/listing')
            ])
            // const res = await this.callApi('get', 'api/items/listing')
            if(res.status==200){
                console.log()
                this.setData = res.data.data.data;
            }else{
                this.swr()
            }
        }
    }
</script>
