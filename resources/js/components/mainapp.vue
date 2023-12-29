<style>
    .ivu-select-dropdown {
        position: static !important;
        /*box-shadow: 0px;*/
    }
</style>
<template>
    <div>
        <div v-if="isLoggedIn">
            <!--          v-if="$store.state.user"-->
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu" >
                <div class="_1side_menu_logo">
                    <h3 style="text-align:center;">Logo Image</h3>
                    <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Admin</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
<!--                                <router-link to="/">home</router-link>-->
                            <li><router-link to="/"><Icon type="ios-speedometer"/>Home</router-link></li>
                            <li><router-link to="/partiesAccountTransaction"><Icon type="ios-speedometer"/>Trasnsaction</router-link></li>
                            <li  v-for="(items, i) in setData" :key="i"  v-if="setData && setData.length > 0">
                            <Dropdown trigger="click" style="margin-left: 20px">
                                <a href="#">
                                    <Icon type="ios-speedometer" v-if="items.tab_name"/>{{items.tab_name}} <Icon type="ios-arrow-down" />
                                </a>
                                <template #list>
                                    <DropdownMenu><router-link :to="items.route"><Icon type="ios-speedometer"/>{{items.name}}</router-link></DropdownMenu>
<!--                                    <DropdownMenu><router-link to="/subAccounts"><Icon type="ios-speedometer"/>Sub Accounts</router-link></DropdownMenu>-->
<!--                                    <DropdownMenu><router-link to="/accountSubAccounts"><Icon type="ios-speedometer"/>Account Sub Accounts</router-link></DropdownMenu>-->
                                </template>
                            </Dropdown>
                            </li>
<!--                            <li>-->
<!--                                <Dropdown trigger="click" style="margin-left: 20px">-->
<!--                                    <a href="#">-->
<!--                                        <Icon type="ios-speedometer" />Party Transaction<Icon type="ios-arrow-down"/>-->
<!--                                    </a>-->
<!--                                    <template #list>-->
<!--                                        <DropdownMenu><router-link to="/parties"><Icon type="ios-speedometer"/>Parties</router-link></DropdownMenu>-->
<!--                                        <DropdownMenu><router-link to="/trasnsactions"><Icon type="ios-speedometer"/>Transactions</router-link></DropdownMenu>-->
<!--                                        <DropdownMenu><router-link to="/partiesTransaction"><Icon type="ios-speedometer"/>Parties Transactions</router-link></DropdownMenu>-->
<!--                                    </template>-->
<!--                                </Dropdown>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <Dropdown trigger="click" style="margin-left: 20px">-->
<!--                                    <a href="#">-->
<!--                                        <Icon type="ios-speedometer" />Allocation<Icon type="ios-arrow-down" />-->
<!--                                    </a>-->
<!--                                    <template #list>-->
<!--                                        <DropdownMenu><router-link to="/roles"><Icon type="ios-speedometer"/>Roles</router-link></DropdownMenu>-->
<!--                                        <DropdownMenu><router-link to="/adminusers"><Icon type="ios-speedometer"/>Admin Uers</router-link></DropdownMenu>-->
<!--                                        <DropdownMenu><router-link to="/permissions"><Icon type="ios-speedometer"/>Permission</router-link></DropdownMenu>-->
<!--&lt;!&ndash;                                        <DropdownMenu><router-link to="/rolePermissions"><Icon type="ios-speedometer"/>Role Permission</router-link></DropdownMenu>&ndash;&gt;-->
<!--                                        <DropdownMenu><router-link to="/assignRole"><Icon type="ios-speedometer"/>Assign Role</router-link></DropdownMenu>-->
<!--                                    </template>-->
<!--                                </Dropdown>-->
<!--                            </li>-->

<!--                            <li><router-link to="/tags"><Icon type="ios-speedometer"/>Tags</router-link></li>-->
<!--                            <li><router-link to="/adminusers"><Icon type="ios-speedometer"/>Admin Uers</router-link></li>-->
<!--                            <li><router-link to="/rolePermissions"><Icon type="ios-speedometer"/>Role Permission</router-link></li>-->
<!--                            <li><router-link to="/roles"><Icon type="ios-speedometer"/>Roles</router-link></li>-->
<!--                            <li><router-link to="/permissions"><Icon type="ios-speedometer"/>Permissoins</router-link></li>-->
<!--                            <li><router-link to="/partiesAccountTransaction"><Icon type="ios-speedometer"/>Parties Account Trasnsaction</router-link></li>-->
<!--                            <li><router-link to="/partiesTransaction"><Icon type="ios-speedometer"/>Parties Transactions</router-link></li>-->
<!--                            <li><router-link to="/trasnsactions"><Icon type="ios-speedometer"/>Transactions</router-link></li>-->
<!--                            <li><router-link to="/parties"><Icon type="ios-speedometer"/>Parties</router-link></li>-->
<!--                            <li><router-link to="/accountSubAccounts"><Icon type="ios-speedometer"/>Account Sub Accounts</router-link></li>-->
<!--                            <li><router-link to="/subAccounts"><Icon type="ios-speedometer"/>Sub Accounts</router-link></li>-->
<!--                            <li><router-link to="/accounts"><Icon type="ios-speedometer"/>Accounts</router-link></li>-->
<!--                            <li v-for="(menuItem, i) in permission" :key="i" v-if="permission.length && menuItem.read">-->
<!--                                <router-link :to="'/'+menuItem.name"><Icon type="ios-speedometer" /> {{menuItem.resourceName}}</router-link>-->
<!--                            </li>-->


                            <!-- <li><router-link to="tags"><Icon type="ios-speedometer" /> Tags</router-link></li>
                            <li><router-link to="category"><Icon type="ios-speedometer" /> Category</router-link></li>
                            <li><router-link to="adminusers"><Icon type="ios-speedometer" /> Admin users</router-link></li>
                            <li><router-link to="role"><Icon type="ios-speedometer" /> Role Management</router-link></li>
                            <li><router-link to="assignRole"><Icon type="ios-speedometer" /> Assign role</router-link></li> -->


                            <li><a href="/logout"><Icon type="ios-speedometer" /> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <Icon type="ios-list" />
                            </li>
                            <!--<li><Icon type="ios-albums" /></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <router-view/>
    </div>
</template>
<script>
    export default {
        props: ['setPermission'],
        data(){
            return {
                isLoggedIn : false,
                setData : "",
            }
        },
        created(){
            console.log("HERE")
            // this.$store.commit('setUpdateUser', this.user);
            // this.$store.dispatch('setUserPermission', this.permission);
            this.setData = JSON.parse(localStorage.getItem('storedData'));
            if (this.setData && this.setData.length > 0) {
                this.isLoggedIn = true;
            }
        }
    }
</script>

