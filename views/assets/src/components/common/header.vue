<template>
    <div class="pm-header-title-content" v-if="isProjectLoaded">
        <div class="header-row-1">
            <div class="project-title">
                <span class="title">{{ project.title }}</span>
                
                <div class="settings first header-settings" v-if="is_manager()">
                    <pm-popper trigger="click" :options="popperOptions" :force-show="projectFormStatus">
                        <div class="pm-popper popper">
                            <edit-project v-if="is_manager()" class="project-edit-form" :project="project" @makeFromClose="makeFromClose"></edit-project>
                        </div>
                        <!-- popper trigger element -->
                        <a href="#" @click.prevent="checkFormStatus" slot="reference" :title="__( 'action', 'wedevs-project-manager')" class="pm-project-update-wrap pm-popper-ref popper-ref icon-pm-pencil project-update-btn"></a>
                        
                    </pm-popper>
                </div>
                <div class="action-settings settings header-settings" v-if="is_manager()">
                    <pm-popper trigger="click" :options="popperOptions">
                        <div class="pm-popper popper">
                            <div v-if="is_manager()" class="pm-action-menu-container">
                                <ul class="action-ul">
                                    <li>
                                        <a @click.prevent="selfProjectMarkDone(project)" href="#">
                                            <span v-if="project.status === 'incomplete'" class="icon-pm-completed"></span>
                                            <span v-if="project.status === 'incomplete'">{{ __( 'Complete', 'wedevs-project-manager') }}</span>

                                            <span v-if="project.status === 'complete'" class="icon-pm-undo-arrow"></span>
                                            <span v-if="project.status === 'complete'">{{ __( 'Restore', 'wedevs-project-manager') }}</span>
                                        </a>
                                    </li>
                                
                                    <li>
                                        <a href="#" @click.prevent="deleteProject(project.id)" :title="__( 'Delete project', 'wedevs-project-manager')">

                                            <span class="icon-pm-delete"></span>
                                            <span class="">{{ __( 'Delete', 'wedevs-project-manager') }}</span>
                                        </a>
                                    </li>
                                    <!-- <do-action :hook="'pm-header-menu'" :actionData="menu"></do-action>  -->
                                </ul>

                            </div>
                        </div>
                        <!-- popper trigger element -->
                        <a href="#" @click.prevent="" slot="reference" :title="__( 'action', 'wedevs-project-manager')" class="pm-popper-ref popper-ref icon-pm-settings header-settings-btn"></a>
                    </pm-popper>

                    <!-- <a href="#" v-if="is_manager()" @click.prevent="showHideSettings()" class="icon-pm-settings header-settings-btn"></a> -->
                </div>
                <div class="settings last header-settings">
                    <a 
                        v-tooltip.top-center="__( 'Project Description', 'wedevs-project-manager' )"
                        href="#" 
                        class="flaticon-text-document"
                        @click.prevent="updateDescriptionVisibility()"
                    />
                </div>

            </div>

            <div class="project-search-box-container">
                <pm-do-action hook="pm_project_header" ></pm-do-action>
            </div>
        </div>

        <div 
            class="description"
            v-if="project.description.content && showDescription"
            v-text="project.description.content"
        />
        <div 
            class="description"
            v-if="!project.description.content && showDescription"
            v-text="__( 'No Description Found!', 'wedevs-project-manager' )"
        />
        <pm-do-action hook="pm_project_before_header_end"></pm-do-action>
    </div> 
    
</template>

<style lang="less">
    
    .pm-header-title-content {
        .header-row-1 {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .description {
            background: #f9f9f9;
            margin-top: 16px;
            padding: 10px;
            border: 1px solid #d7d7d7;
            color: #47525d;
            text-align: justify;
        }

        .settings.header-settings {
            position: relative;

            .project-edit-form {
                left: 0;
                white-space: nowrap;
                padding: 10px 15px !important;
                min-width: 250px;
                @media (max-width: 767px){
                    left: inherit;
                    right: 0px;
                }
                
                .pm-form {
                    .item {
                        margin-right: 0;
                        input[type='text'], input[type='email'], input[type='tel'], textarea, select {
                            width: 100%;
                            &:focus {
                                border-color: #027eb3;
                            }
                        }
                    }
                    
                    .pm-del-proj-role {
                        cursor: pointer;
                    }
                    
                    #project-notify {
                        margin-right: 5px;
                    }
                    
                    table {
                        width: 100%;
                        td:nth-child(2){
                            text-align: center;
                            select {
                                width: 100%;
                            }
                        }
                        td:last-child {
                            text-align: right;
                        }
                    }
                    
                    .submit {
                        .project-cancel {
                            box-shadow: 0 1px 0 #c5c5c5;
                        }
                        
                        .pm-loading:after {
                            margin: 6px 0 0 10px;
                        }
                    }
                }
            }
        }

        .project-status {
            
            .incomplete, .complete {
                border: 1px solid #E5E4E4;
                background: #fff;
                padding: 4px 8px;
                margin-left: 5px;
                cursor: pointer;
                border-radius: 3px;
                color: #788383;
                font-size: 12px;

                &:hover {
                    border: 1px solid #1A9ED4;
                    color: #1A9ED4;
                }
            }
        }
        
        .project-title {
            flex: 1;
            display: flex;
            align-items: center;
            position: relative;

            .project-edit-form {
                text-align: left;
                padding: 5px 5px 15px 15px;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
                border: 1px solid #DDDDDD;
                background: #fff;
                border-radius: 3px;
                box-shadow: 0px 2px 40px 0px rgba(214, 214, 214, 0.6);
            }

            .title {
                font-size: 18px;
                font-weight: bold;
                color: #000;
                margin-right: 20px;
                white-space: nowrap;
            }
            
        }

        .settings {
            position: relative;
            display: flex;
            align-items: center;
            border: 1px solid #E5E4E4;
            border-right-color: #fff;
            background: #fff;
            color: #95A5A6;
            cursor: pointer;

            &:hover {
                border-color: #1A9ED4;

                .icon-pm-settings, .flaticon-text-document, .icon-pm-pencil {
                    &:before {
                        color: #1A9ED4;

                    }
                }
            }

            .flaticon-text-document {
                height: 28px;
                padding: 0 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #95A5A6;

                &:before {
                    font-size: 1rem;
                }
            }

            .header-settings-btn {
                height: 28px;
                padding: 0 10px;
                display: flex;
                align-items: center;
            }

            .icon-pm-pencil {
                height: 28px;
                color: #95A5A6;
                padding: 0px 10px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9;
            }

            .pm-action-menu-container {
                padding: 7px 0;
                background: #fff;
                box-shadow: 0px 2px 40px 0px rgba(214, 214, 214, 0.6);
                border-radius: 3px;
                border: 1px solid #ddd;
                min-width: 120px;
                &:after,
                &:before {
                    display: none;
                }

                @media (max-width: 767px){
                    left: inherit !important;
                    right: 0 !important;
                }

                .action-ul {
                    margin: 0;
                    padding: 0;


                    li {
                        margin: 0;
                        padding: 0;
                        a {
                            display: flex;
                            align-items: center;
                            padding: 5px 10px;

                            .icon-pm-completed, .icon-pm-delete, .icon-pm-undo-arrow {
                                width: 20px;
                            }
                            .icon-pm-undo-arrow {
                                &:before {
                                    font-size: 11px;
                                }
                            }
                        }
                    }
                }
            }
        }

        .settings.first {
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        .settings.last {
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
            border-right: 1px solid #E5E4E4;

            &:hover {
                border-right-color: #1A9ED4;
            }
        }
    }
    
    @media (max-width: 767px){
        .project-search-box-container .pm-search-field input {
            min-width: 100%;
        }
    }

    @media (max-width: 360px) {
        .project-title .pm-project-form .project-cancel {
            margin-bottom: 0px !important;
        }
    }
 
</style>

<script>
    //import router from './../../router/router';
    import do_action from './do-action.vue';
    import edit_project from './../project-lists/project-create-form.vue';
   

    export default {
        data () {
            return {
                project_action: __('Project Actions', 'wedevs-project-manager'),
                settings_hide: false,
                settingStatus: false,
                isEnableUpdateForm: false,
                popperOptions: 
                {
                    placement: 'top-end',
                    modifiers: 
                    { 
                        offset: { 
                            offset: '0, 10px' 
                        } 
                    }
                },
                projectFormStatus : false,
            }

        },
        watch: {
            '$route' (to, from) {
                this.project_id = typeof to.params.project_id !== 'undefined' ? to.params.project_id : 0;
                if(!this.isProjectLoaded) {
                    this.getGloabalProject(to.params.project_id);    
                }
                
                this.getProjectCategories();
                this.getRoles();
            }
        },

        computed: {
            isProjectLoaded () {
                let project = this.$store.state.project;
                
                return jQuery.isEmptyObject(project) ? false : true;
            },

            is_project_edit_mode () {
                return this.$store.state.is_project_form_active;
            },

            project () {
                return  this.$store.state.project;
            },

            hasProject () {

                return this.$store.state.project.hasOwnProperty('id');
            },

            showDescription () {
                return this.$store.state.showDescription;
            }

        },
        
        created () {
            this.getGloabalProject();
            this.getProjectCategories();
            this.getRoles(); 
            window.addEventListener('click', this.windowActivity);
        },

        components: {
            'do-action': do_action,
            'edit-project': edit_project
        },

        methods: {
            updateDescriptionVisibility () {
                let status = this.showDescription ? false : true;
                this.$store.commit( 'updateShowDescription', status );
            },

            windowActivity (el) {
                
                var settingsWrap  = jQuery(el.target).closest('.header-settings'),
                    settingsBtn       = jQuery(el.target).hasClass('header-settings-btn'),
                    projectUpdatebtn  = jQuery(el.target).hasClass('project-update-btn'),
                    projectUdpateWrap = jQuery(el.target).closest('.project-edit-form'),
                    newUser           = jQuery(el.target).hasClass('pm-more-user-form-btn'),
                    newUserbtn        = jQuery(el.target).hasClass('pm-new-user-btn'),
                    userSelect        = jQuery(el.target).closest('.ui-autocomplete'),
                    newUserDialog     = jQuery('.pm-new-user-wrap').dialog('isOpen'),
                    dialogClose       = jQuery(el.target).hasClass('ui-icon-closethick');


                if ( !settingsBtn && !settingsWrap.length ) {
                    this.settingStatus = false;
                }
             
                if ( 
                    !projectUpdatebtn 
                    && !projectUdpateWrap.length 
                    && !newUser 
                    && !userSelect.length 
                    && !newUserbtn
                    && !newUserDialog 
                    && !dialogClose
                ) {
                    this.showHideProjectForm(false);
                    this.projectFormStatus = false;
                }
            },

            enableDisableUpdateForm () {
                this.isEnableUpdateForm = this.isEnableUpdateForm ? false : true;
            },

            showHideSettings () {
                this.settingStatus = this.settingStatus ? false : true;
            },
            showProjectAction () {
                this.settings_hide = !this.settings_hide;
            },

            selfProjectMarkDone () {

                var args = {
                    data: {
                        id : this.project.id,
                        status: this.project.status === 'complete' ? 'incomplete' : 'complete',
                        title: this.project.title,
                    },
                    callback: function ( res ) {
                        this.$root.$store.commit(
                            'showHideProjectDropDownAction', 
                            {
                                status: false, 
                                project_id: this.project_id
                            }
                        );
                    }
                } 

                this.updateProject( args );
            },

            checkFormStatus(){
                if(this.projectFormStatus){
                    this.projectFormStatus = false ;
                } else {
                    this.projectFormStatus = true ;
                }
            },

            makeFromClose(value){
                this.projectFormStatus = value ;
            }
        }
    }
</script>
