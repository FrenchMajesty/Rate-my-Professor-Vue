<template>
	<div class="md-layout md-gutter no-margin md-alignment-top-space-around">
		<md-card 
			class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-45 md-size-40 vertical-spacing" 
			md-with-hover
		>
			<md-card-header v-if="professor" class="animated fadeIn">
				<md-card-header-text>
					<div class="md-title">{{professor.name}}</div>
					<div class="md-subhead">Professor of {{professor.department.name}} at {{professor.school.name}}</div>
				</md-card-header-text>

				<md-card-media md-medium>
	            	<md-icon class="md-size-4x">school</md-icon>
				</md-card-media>
			</md-card-header>

			<md-card-actions>
				<md-button class="md-icon-button">
	            	<md-icon>share</md-icon>
      				<md-tooltip md-direction="top">Share this professor's page</md-tooltip>
	          	</md-button>
				<md-button 
					v-if="professor"
					:to="{name: 'professor', params:{slug: professor.slug}}"
				>Open profile page</md-button>
			</md-card-actions>
		</md-card>
		<md-card class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-45 md-size-50">
			<SmartForm :submit="submitForm" :form="form">
				<md-card-header>
					<h1 class="md-title">Rate your professor</h1>
					<span class="md-subhead" v-if="professor">It's your turn to grade Professor {{professor.name}}! Make sure to give an accurate review, the fate of future students is in your hands.</span>
				</md-card-header>

				<md-switch
					class="switcher"
					v-model="form.textbook_used"
					@change="form.errors.clear('textbook_used')"
				>Was the textbook used?</md-switch>
				<p 
					class="text-red"
      				v-if="form.errors.has('textbook_used')"
      				v-text="form.errors.get('textbook_used')"
				></p>

				<md-switch 
					class="switcher"
					v-model="form.would_retake"
					@change="form.errors.clear('would_retake')"
					>Would you re-take this prof again?</md-switch>
				<p 
					class="text-red"
      				v-if="form.errors.has('would_retake')"
      				v-text="form.errors.get('would_retake')"
				></p>

				<md-field :class="{'md-invalid': form.errors.has('class')}">
					<md-icon>school</md-icon>
					<label>Your class code:</label>
					<md-input
						data-name="class"
						:value="form.class.toUpperCase().replace(/\s/,'')" 
						@input="form.class = $event"
						placeholder="Please enter your class code here."
						:maxlength="10"
					></md-input>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('class')"
	      				v-text="form.errors.get('class')"
	      			></span>
	      			<span 
	      				class="md-helper-text" 
	      				v-else
	      			>
	      				Make sure to type this correctly or else your review could be <b>removed</b>.
	      			</span>
				</md-field>

				<md-field :class="{'md-invalid': form.errors.has('grade_received')}">
			    	<label for="grade">The grade you received:</label>
			        <md-select 
			        	v-model="form.grade_received"
			        	name="grade"
			        	id="grade"
			        	@md-opened="form.errors.clear('grade_received')"
			        >
			        	<md-option 
			        		v-for="(grade, i) in grades"
			        		:key="i"
			        		:value="grade"
			        	>{{grade}}</md-option>
			        </md-select>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('grade_received')"
	      				v-text="form.errors.get('grade_received')"
	      			></span>
				</md-field>

				<label>Select up to {{tagsLimit}} tags that best describe your professor:</label>
				<br/>
				<md-chip 
					v-if="tags"
					v-for="(tag, i) in tags" 
					:key="tag.id" 
					:data-id="tag.id"
    				:class="generateTagClass(tag.id)" 
    				@click="toggleTag"
    				style="margin-top: 1em"
    			>{{tag.name}}</md-chip>
    			<p 
					class="text-red"
      				v-if="form.errors.has('tags_id')"
      				v-text="form.errors.get('tags_id')"
				></p>

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
	import { createProfessorReview } from 'Js/store/api';

	export default {
		name: 'RateProfessor',
		components: {
			SmartForm,
		},

		/**
		 * Fetch all the professors and schools datas
		 */
		beforeCreate() {
			Fetcher.all(this);
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
				 * The form object for the form to rate a professor
				 * @type {Form}
				 */
				form: new Form({
					professor_id: this.$route.params.id,
					overall_rating: '',
					difficulty_rating: '',
					would_retake: false,
					textbook_used: false,
					grade_received: '',
					class: '',
					comment: '',
					tags_id: '',
				}),

				/**
				 * Whether the form is waiting for the server's response
				 * @type {Boolean}
				 */
				isSubmitting: false,

				/**
				 * The ID of the tags that have been selected to describe this prof
				 * @type {Array}
				 */
				selectedTagsId: [],

				/**
				 * The possible grades that a student can receive in a class
				 * @type {Array}
				 */
				grades: ['A+','A','A-','B+','B','B-','C+','C','C-','D+','D','D-','F','Dropped','Not sure yet','Rather not say'],

				/**
				 * The maximum number of tags allowed per review
				 * @type {Number}
				 */
				tagsLimit: 3,
			}
		},
		computed: {

			/**
			 * Determine whether the datas are ready to be used
			 * @return {Boolean} 
			 */
			dataIsReady() {
				return this.$store.getters.profDataIsReady;
			},
			/**
			 * Get the professor for whom this review is being written for
			 * @return {Object|Void} 
			 */
			professor() {
				const {id} = this.$route.params;
				const {fullProfessor} = this.$store.getters;

				if(this.dataIsReady) {
					return fullProfessor(id);
				}
			},

			/**
			 * Get the review tags to describe the review
			 * @return {Array} 
			 */
			tags() {
				return this.$store.state.tags.data;
			},
		},
		watch: {
			/**
			 * When the data is ready and no professor with the given slug exists then 
			 * show an error page
			 * @param  {Boolean} isReady The value of the 'dataIsReady' computed property
			 * @return {Void}          
			 */
			dataIsReady(isReady) {
				if(isReady && !this.professor) {
					this.$router.push({name: 'notFound'});
				}
			},

			/**
			 * Keep the `selectedTagsId` array and form.tags_id synchronized
			 * @param  {Array} tagsId The array of the tags selected
			 * @return {Void}        
			 */
			selectedTagsId(tagsId) {
				this.form.tags_id = tagsId.join(',');
			}
		},
		methods: {
			/**
			 * Generate the given tag's class if it's selected
			 * @param  {Number} id The ID of the tag for whom to generate the class
			 * @return {String|Void}    
			 */
			generateTagClass(id) {
				const isSelected = this.selectedTagsId.some(tagId => tagId == id);

				if(isSelected) {
					return 'md-primary';
				}
			},

			/**
			 * Change the selected status of the tag that was clicked on
			 * @param  {HTMLElement} e.target The click event's target
			 * @return {Void}                
			 */
			toggleTag({target}) {
				const id = Number(target.getAttribute('data-id'));
				const isSelected = this.selectedTagsId.some(tagId => tagId == id);
				this.form.errors.clear('tags_id');

				if(isSelected) {
					this.selectedTagsId = this.selectedTagsId.filter(tagId => tagId != id);
					return;
				}

				if(this.selectedTagsId.length < this.tagsLimit) {
					this.selectedTagsId.push(id);
				}
			},
			
			/**
			 * Handle the submitting of the form
			 * @return {Void} 
			 */
			submitForm() {
				const success = () => {
					alert('Your review was successfully sent!');

					const params = { slug: this.professor.slug };
					this.$router.push({name: 'professor', params});
				};

				this.form.submit(createProfessorReview).then(success);
			},
		}
	}
</script>

<style scoped>
	.text-red {
		color: #ff1744;
	}
</style>