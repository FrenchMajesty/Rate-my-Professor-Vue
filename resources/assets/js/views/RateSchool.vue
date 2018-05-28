<template>
	<div class="md-layout md-gutter no-margin md-alignment-top-space-around">
		<md-card 
			class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-45 md-size-40 vertical-spacing" 
			md-with-hover
		>
			<md-card-header v-if="school" class="animated fadeIn">
				<md-card-header-text>
					<div class="md-title">{{school.name}}</div>
					<div class="md-subhead">Located at {{school.location}}</div>
				</md-card-header-text>

				<md-card-media md-medium>
	            	<md-icon class="md-size-4x">account_balance</md-icon>
				</md-card-media>
			</md-card-header>

			<md-card-actions>
				<md-button class="md-icon-button">
	            	<md-icon>share</md-icon>
      				<md-tooltip md-direction="top">Share this school's page</md-tooltip>
	          	</md-button>
				<md-button 
					v-if="school"
					:to="{name: 'school', params:{slug: school.slug}}"
				>Open profile page</md-button>
			</md-card-actions>
		</md-card>
		<md-card class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-45 md-size-50">
			<SmartForm :submit="submitForm" :form="form">
				<md-card-header>
					<h1 class="md-title">Rate your school</h1>
					<span class="md-subhead" v-if="school">As an insider, you have a valuable perspective that other students want to hear about. If you were writing to your past self before applying there, how would you rate {{school.name}}?</span>
				</md-card-header>

				<!-- sliders go here -->

				<md-field :class="{'md-invalid': form.errors.has('comment')}">
			      	<label>Write your review:</label>
			     	<md-textarea 
			     		data-name="comment"
			     		v-model="form.comment"
			     		placeholder="You can press Enter to go to the next line."
			     		:maxlength="350"
			      		md-autogrow
			    	></md-textarea>
			    	<md-icon>description</md-icon>
			    	<span 
	      				class="md-error"
	      				v-if="form.errors.has('comment')"
	      				v-text="form.errors.get('comment')"
	      			></span>
			    </md-field>

			    <p>By clicking the submit button, I acknowledge that I have read and agreed to the <a href="#">Site Guidelines</a>, <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</p>

	    		<md-progress-bar v-if="isSubmitting" md-mode="query"></md-progress-bar>
				<md-card-actions>
					<md-button :disabled="form.errors.any()" type="submit">Submit my review</md-button>
				</md-card-actions>
			</SmartForm>
		</md-card>
	</div>
</template>

<script>
	import Form from 'Js/lib/Form';
	import Fetcher from 'Js/lib/Fetcher';
	import SmartForm from 'Js/components/common/SmartForm';
	import { createSchoolReview } from 'Js/store/api';

	export default {
		name: 'RateProfessor',
		components: {
			SmartForm,
		},

		/**
		 * Fetch all the schools datas
		 */
		beforeCreate() {
			Fetcher.schools(this);
		},

		/**
		 * Get the quick review from the store's state and reset its value
		 */
		created() {
			const {quick} = this.$store.state.reviews;
			this.form.comment = quick;

			this.$store.commit('writeQuickReview','');
		},
		data() {
			return {
				/**
				 * The form object for the form to rate a school
				 * @type {Form}
				 */
				form: new Form({
					school_id: this.$route.params.id,
					overall: 3,
					location: 3,
					opportunity: 3,
					facilities: 3,
					social: 3,
					comment: '',
				}),

				/**
				 * Whether the form is waiting for the server's response
				 * @type {Boolean}
				 */
				isSubmitting: false,
			}
		},
		computed: {

			/**
			 * Determine whether the datas are ready to be used
			 * @return {Boolean} 
			 */
			dataIsReady() {
				return this.$store.getters.schoolDataIsReady;
			},

			/**
			 * Get the school for whom this review is being written for
			 * @return {Object|Void} 
			 */
			school() {
				const {id} = this.$route.params;
				const {fullSchool} = this.$store.getters;

				if(this.dataIsReady) {
					return fullSchool(id);
				}
			},
		},
		watch: {
			/**
			 * When the data is ready and no school with the given slug exists then 
			 * show an error page
			 * @param  {Boolean} isReady The value of the 'dataIsReady' computed property
			 * @return {Void}          
			 */
			dataIsReady(isReady) {
				if(isReady && !this.school) {
					this.$router.push({name: 'notFound'});
				}
			},
		},
		methods: {
			
			/**
			 * Handle the submitting of the form
			 * @return {Void} 
			 */
			submitForm() {
				const success = () => {
					alert('Your review was successfully sent!');

					const params = { slug: this.school.slug };
					this.$router.push({name: 'school', params});
				};

				this.form.submit(createSchoolReview).then(success);
			},
		}
	}
</script>

<style scoped>
	.text-red {
		color: #ff1744;
	}
</style>