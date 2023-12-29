<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
          <p class="_title0">
            <h5 class="mb-3">Role Manangement</h5>
             <Select v-model="data.id"  placeholder="Select admin type" style="width:300px" @on-change="changeAdmin">
                <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.name}}</Option>
             </Select>
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>Resource name</th>
                <th>Read</th>
                <th>Write</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
              <!-- TABLE TITLE -->

              <!-- ITEMS -->
              <tr v-for="(r, i) in permissions" :key="i" v-if="permissions.length">
                <td>{{r.name}}</td>
                <td><Checkbox v-model="r.read"></Checkbox></td>
                <td><Checkbox v-model="r.write"></Checkbox></td>
                <td><Checkbox v-model="r.update"></Checkbox></td>
                <td><Checkbox v-model="r.delete"></Checkbox></td>
              </tr>
              <!-- ITEMS -->
              <div class="center_button">
                  <Button type="primary" :loading="isSending" :disabled="isSending" @click="assignRoles">Assign</Button>
              </div>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      data: {
        id: null
      },
      isSending : false,
     roles: [],
     permissions : [],
    };
  },

  methods: {
     async assignRoles(){
         if(this.data.id == null) return this.e('Please select User Type');
         let data = JSON.stringify(this.permissions);
         console.log(data);

         const res = await this.callApi('post','api/role/assignRole', {'permissions' : data, 'id': this.data.id})
         if(res.status==200){
            this.s('Role has been assigned successfully!')
            location.reload();
         }else{
           this.swr()
         }
     },
     changeAdmin(){
       let index = this.roles.findIndex(role => role.id == this.data.id)
       let permission = this.roles[index].permissions;
         console.log(permission);
       if(!permission){
           this.permissions = this.permissionsDefault;
       }else{
         this.permissions = JSON.parse(permission)
       }
     }
  },
    async created(){
        const [res, resPermission] = await Promise.all([
            this.callApi('get', 'api/role/listing'),
            this.callApi('get', 'api/permission/listing'),
        ])
        if(res.status==200){
            this.roles = res.data.data.data;
            // if(this.roles.length){
            //     this.data.id = this.roles[0].id;
            //     if(this.roles[0].permissions){
            //         this.permissions = this.roles[0].permissions;
            //     }
            // }
        }else{
            this.swr()
        }
        if(resPermission.status==200){
            this.permissions = resPermission.data.data.data;
            this.permissions = this.permissions.map(permission => ({
                ...permission,
                read: false, write: false, update: false, delete: false
            }));
            this.permissionsDefault = this.permissions;
        }else{
            this.swr()
        }
    }
};
</script>
