<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0"><Button @click="addModal=true"><Icon type="md-add" /> Add Account Sub Account</Button></p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Account</th>
                                <th>Sub Account</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(items, i) in setData" :key="i" v-if="setData.length">
                                <td>{{items.id}}</td>
                                <td class="_table_name">{{items.account.name}}</td>
                                <td>{{items.sub_account.name}}</td>
                                <td>
<!--                                    <Button type="info" size="small" @click="showEditModal(items, i)">Edit</Button>-->
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
                <Modal v-model="addModal" title="Add Account" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Select v-model="data.account_id"  placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in accounts" :key="i" v-if="accounts.length">{{r.name}}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <div class="row">
                            <div class="col-3"  v-for="(r, i) in subAccounts" :key="i" v-if="subAccounts.length">
                                <input type="checkbox" :value="r.id" v-model="data.sub_account_id" />
                                {{r.name}}
                            </div>
                        </div>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addItem" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add'}}</Button>
                    </div>

                </Modal>
                <!-- editing modal -->
                <Modal v-model="editModal" title="Edit Role" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Select v-model="editData.account_id"  placeholder="Select Account">
                            <Option :value="r.id" v-for="(r, i) in accounts" :key="i" v-if="accounts.length">{{r.name}}</Option>
                        </Select>
                    </div>
                    <div class="space">
                        <Select v-model="editData.sub_account_id"  placeholder="Select Sub Account">
                            <Option :value="r.id" v-for="(r, i) in subAccounts" :key="i" v-if="subAccounts.length">{{r.name}}</Option>
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="editItemBtn" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Account'}}</Button>
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
                    account_id: '',
                    sub_account_id: [],
                },
                addModal : false,
                editModal : false,
                isAdding : false,
                setData : [],
                editData : {
                    account_id: '',
                    sub_account_id: [],
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
                accounts: [],
                subAccounts: [],

            }
        },

        methods : {
            async addItem(){
                if(this.data.account_id =='') return this.e('Account is required')
                if(this.data.sub_account_id == '') return this.e('Sub Account is required')
                const res = await this.callApi('post', 'api/account_sub_account/store', this.data)
                if(res.status===200){
                    const setItemData = res.data.data;
                    // this.setData.unshift(setItemData);
                    this.s('Items has been added successfully!');
                    this.addModal = false;
                    this.data.account_id = '';
                    this.data.sub_account_id = [];
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
            async editItemBtn(){
                if(this.editData.account_id =='') return this.e('Account is required')
                if(this.editData.sub_account_id =='') return this.e('Sub Account is required')
                const res = await this.callApi('post', 'api/account_sub_account/update', this.editData)
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
                    account_id : items.account_id,
                    sub_account_id : items.sub_account_id,
                }
                this.editData = obj;
                this.editModal = true;
                this.index = index
            },
            async deleteItemBtn(){
                this.isDeleing = true;
                const res = await this.callApi('post', 'api/account_sub_account/delete', this.deleteItem)
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
                const res = await this.callApi('post', 'api/account_sub_account/updateIsActive', setIsActive)
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
                const res = await this.callApi('post', 'api/account_sub_account/updateIsShow', setIsShow)
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
            const [res, resAccount,resSubAccount] = await Promise.all([
                this.callApi('get', 'api/account_sub_account/listing'),
                this.callApi('get', 'api/account/listing'),
                this.callApi('get', 'api/sub_account/listing'),
            ])
            if(res.status==200){
                console.log(res.data.data.data);
                this.setData = res.data.data.data;
            }else{
                this.swr()
            }
            if(resAccount.status==200){
                this.accounts = resAccount.data.data.data;
            }else{
                this.swr()
            }
            if(resSubAccount.status == 200){
                this.subAccounts = resSubAccount.data.data.data;
            }else{
                this.swr()
            }
        }
    }
</script>
