<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button @click="addModal=true"><Icon type="md-add" /> Add admin</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>User type</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(user, i) in setUsers" :key="i" v-if="setUsers.length">
								<td>{{user.id}}</td>
								<td class="_table_name">{{user.name}}</td>
								<td class="">{{user.email}}</td>
								<td class="">{{user.roles[0].name}}</td>
								<td>{{user.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(user, i)"  :loading="user.isDeleting">Delete</Button>
                                    <Button type="success" size="small" @click="showStatusesModal(user, i)">{{user.is_active == 1 ? 'Active' : 'Deactive'}}</Button>
                                    <Button type="warning" size="small" @click="showShowsModal(user, i)">{{user.is_show == 1 ? 'Showing' : 'Not Showing'}}</Button>

								</td>
							</tr>
								<!-- ITEMS -->
					</table>
					</div>
				</div>


				<!-- tag adding modal -->
				<Modal v-model="addModal" title="Add admin" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Input type="text" v-model="data.name" placeholder="Full name" autocomplete="off" />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="data.email" placeholder="Email"  autocomplete="off" />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password" placeholder="Password" autocomplete="off"  />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="data.password_confirmation" placeholder="Password" autocomplete="off"  />
                    </div>
                    <div class="space">
                        <Select v-model="data.role_id"  placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.name}}</Option>
                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>
					<div slot="footer">
						<Button type="default" @click="addModal=false">Close</Button>
						<Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add admin'}}</Button>
					</div>

				</Modal>
				<!-- tag editing modal -->
				<Modal v-model="editModal" title="Edit Admin" :mask-closable="false" :closable="false">
                    <div class="space">
                        <Input type="text" v-model="editData.name" placeholder="Full name"  />
                    </div>
                    <div class="space">
                        <Input type="email" v-model="editData.email" placeholder="Email"  />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="editData.password" placeholder="Password"  />
                    </div>
                    <div class="space">
                        <Input type="password" v-model="editData.password_confirmation" placeholder="Password Confirmation"  />
                    </div>
                    <div class="space">
                        <Select v-model="editData.role_id"  placeholder="Select admin type">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.name}}</Option>
                            <!-- <Option value="Editor" >Editor</Option> -->
                        </Select>
                    </div>
					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Admin'}}</Button>
					</div>
				</Modal>
				<!-- delete alert modal -->
				 <Modal v-model="showDeleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete tag?.</p>

					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleing" :disabled="isDeleing" @click="deleteUser" >Delete</Button>
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
						<Button type="success" size="large" long :loading="isStatus" :disabled="isStatus" @click="statusUser">Change Status</Button>
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
						<Button type="success" size="large" long :loading="isStatus" :disabled="isStatus" @click="showUser">Show or Not</Button>
					</div>
				</Modal>

			</div>
		</div>
    </div>
</template>


<script>
/*import deleteModal from '../components/deleteModal.vue'
import { mapGetters } from 'vuex'*/
console.log(this)
export default {
	data(){
		return {
			data : {
				name: '',
				email: '',
				password: '',
                password_confirmation: '',
				role_id: null
			},
			addModal : false,
			editModal : false,
			isAdding : false,
			setUsers : [],
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
            if(this.data.email.trim()=='') return this.e('Email is required')
			if(this.data.password.trim()=='') return this.e('Password is required')
			if(this.data.password_confirmation.trim()=='') return this.e('Confirm Password is required')

            if(!this.data.role_id) return this.e('User type  is required')

			const res = await this.callApi('post', 'api/user/store', this.data)
            console.log("I AM HERE")
            console.log(res.status);
            if(res.status===200){
                const setUserData = res.data.data;
                console.log("SADFFFFFF");
                console.log(setUserData);
				// this.setUsers.unshift(setUserData);
				this.s('Admin user has been added successfully!');
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
            if(this.editData.email.trim()=='') return this.e('Email is required')
            if(!this.editData.role_id) return this.e('User type  is required')
			const res = await this.callApi('post', 'api/user/update', this.editData)
			if(res.status===200){
				this.setUsers[this.index] = this.editData;
				this.s('User has been edited successfully!')
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
		showEditModal(user, index){
			let obj = {
				id : user.id,
				name : user.name,
				email : user.email,
				role_id : user.roles[0].id,
			}
			this.editData = obj;
			this.editModal = true;
			this.index = index
		},
		async deleteUser(){
			this.isDeleing = true;
			const res = await this.callApi('post', 'api/user/delete', this.deleteItem)
			if(res.status===200){
				this.setUsers.splice(this.deleteItem,1)
				this.s('User has been deleted successfully!')
			}else{
				this.swr()
			}
			this.isDeleing = false
			this.showDeleteModal = false

		},
        async statusUser(){
			this.isStatus = true;
			const setIsActive = {'id':this.statusItem.id};
			const res = await this.callApi('post', 'api/user/updateIsActive', setIsActive)
			if(res.status===200){
				// this.setUsers.splice(this.statusItem,1)
                window.location.reload();

                this.s('User Status Change successfully!')
			}else{
				this.swr()
			}
			this.isShow = false
			this.showStatusModal = false

		},async showUser(){
			this.isShow = true;
			const setIsShow = {'id':this.showItem.id};
			const res = await this.callApi('post', 'api/user/UpdateIsShow', setIsShow)
			if(res.status===200){
				// this.setUsers.splice(this.showItem,1)
                window.location.reload();

                this.s('User Status Change successfully!')
			}else{
				this.swr()
			}
			this.isShow = false
			this.showShowModal = false

		},
		showDeletingModal(user, i){
            this.deleteItem = user,
            this.showDeleteModal =  true
		},
        showStatusesModal(user, i) {
            this.statusItem = user,
            this.showStatusModal = true
        },
        showShowsModal(user, i){
            this.showItem = user,
            this.showShowModal =  true
        }
	},

	async created(){
        const [res, resRole] = await Promise.all([
            this.callApi('get', 'api/user/listing'),
            this.callApi('get', 'api/user/role/listing')
        ])
        // const res = await this.callApi('get', 'api/user/listing')
		if(res.status==200){
            console.log()
			this.setUsers = res.data.data.data;
		}else{
			this.swr()
		}
		if(resRole.status==200){
			this.roles = resRole.data.data;
		}else{
			this.swr()
		}
	},
	// components : {
	// 	deleteModal
	// },
	computed : {
		// ...mapGetters(['getDeleteModalObj'])
	},
	watch : {
		getDeleteModalObj(obj){
			if(obj.isDeleted){
				this.tags.splice(obj.deletingIndex,1)
			}
		}
	}




}
</script>
