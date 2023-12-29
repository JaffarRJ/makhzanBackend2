<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0"><Button @click="addModal=true"><Icon type="md-add" /> Add Role</Button></p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tr v-for="(items, i) in setData" :key="i" v-if="setData.length">
                                <td>{{items.id}}</td>
                                <td class="_table_name">{{items.name}}</td>
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
                <Modal v-model="addModal" title="Add Role" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Input type="text" v-model="data.name" placeholder="Role Name" autocomplete="off" />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Role'}}</Button>
                    </div>

                </Modal>
                <!-- editing modal -->
                <Modal v-model="editModal" title="Edit Role" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Input type="text" v-model="editData.name" placeholder="Full name"  />
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Role'}}</Button>
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
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                setData : [],
                editData : {
                    name: ''
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
                roles: []

            }
        },

        methods : {
            async addAdmin(){
                if(this.data.name.trim()=='') return this.e('Name is required')

                const res = await this.callApi('post', 'api/role/store', this.data)
                console.log("I AM HERE")
                console.log(res.status);
                if(res.status===200){
                    const setItemData = res.data.data;
                    console.log("SADFFFFFF");
                    console.log(setItemData);
                    // this.setData.unshift(setItemData);
                    this.s('Admin items has been added successfully!');
                    this.addModal = false;
                    this.data.name = '';
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
            async editAdmin(){
                if(this.editData.name.trim()=='') return this.e('Name is required')
                const res = await this.callApi('post', 'api/role/update', this.editData)
                if(res.status===200){
                    this.setData[this.index] = this.editData;
                    this.s('items has been edited successfully!')
                    this.editModal = false

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
                }
                this.editData = obj;
                this.editModal = true;
                this.index = index
            },
            async deleteItemBtn(){
                this.isDeleing = true;
                const res = await this.callApi('post', 'api/role/delete', this.deleteItem)
                if(res.status===200){
                    this.setData.splice(this.deleteItem,1)
                    this.s('items has been deleted successfully!')
                }else{
                    this.swr()
                }
                this.isDeleing = false
                this.showDeleteModal = false

            },
            async statusItemBtn(){
                this.isStatus = true;
                const setIsActive = {'id':this.statusItem.id};
                const res = await this.callApi('post', 'api/role/updateIsActive', setIsActive)
                if(res.status===200){
                    // this.setData.splice(this.statusItem,1)
                    window.location.reload();

                    this.s('items Status Change successfully!')
                }else{
                    this.swr()
                }
                this.isShow = false;
                this.showStatusModal = false;

            },async showItemBtn(){
                this.isStatus = true;
                const setIsShow = {'id':this.showItem.id};
                const res = await this.callApi('post', 'api/role/updateIsShow', setIsShow)
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
                this.callApi('get', 'api/role/listing'),
                // this.callApi('get', 'api/role/role/listing')
            ])
            // const res = await this.callApi('get', 'api/items/listing')
            if(res.status==200){
                this.setData = res.data.data.data;
                console.log(this.setData);
            }else{
                this.swr()
            }
        }
    }
</script>
