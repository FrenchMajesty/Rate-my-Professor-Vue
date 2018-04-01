<template>
	<div class="md-layout md-gutter no-margin md-alignment-top-space-around">
		<md-card class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-45 md-size-40 vertical-spacing" md-with-hover>
			<md-card-header>
				<md-card-header-text>
					<div class="md-title">{{professor.name}}</div>
					<div class="md-subhead">Professor of @... at @... University</div>
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
				<md-button :to="{name: 'professor', params:{slug: professor.slug}}">Open profile page</md-button>
			</md-card-actions>
		</md-card>
		<md-card class="md-layout-item md-xsmall-size-90 md-small-size-80 md-medium-size-45 md-size-50">
			<form 
				@submit.preventDefault="submitForm" 
				@keydown="clearFieldErrors"
			>
				<md-card-header>
					<h1 class="md-title">Rate your professor</h1>
					<span class="md-subhead">It's your turn to grade Professor {{professor.name}}! Make sure to give an accurate review, the fate of future students is in your hands.</span>
				</md-card-header>

				<md-switch class="switcher" v-model="form.textbook">Was the textbook used?</md-switch>
				<p 
					class="text-red"
      				v-if="form.errors.has('textbook')"
      				v-text="form.errors.get('textbook')"
				></p>

				<md-switch class="switcher" v-model="form.retake">Would you re-take this prof again?</md-switch>
				<p 
					class="text-red"
      				v-if="form.errors.has('retake')"
      				v-text="form.errors.get('retake')"
				></p>

				<md-field :class="{'md-invalid': form.errors.has('classcode')}">
					<md-icon>school</md-icon>
					<label>Your class code:</label>
					<md-input
						data-name="classcode"
						:value="form.classcode.toUpperCase().replace(/\s/,'')" 
						@input="form.classcode = $event"
						placeholder="Please enter your class code here."
						:maxlength="10"
					></md-input>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('classcode')"
	      				v-text="form.errors.get('classcode')"
	      			></span>
	      			<span 
	      				class="md-helper-text" 
	      				v-else
	      			>
	      				Make sure to type this correctly or else your review could be <b>removed</b>.
	      			</span>
				</md-field>

				<md-field :class="{'md-invalid': form.errors.has('grade')}">
			    	<label for="grade">The grade you received:</label>
			        <md-select v-model="form.grade" name="grade" id="grade">
			        	<md-option 
			        		v-for="(grade, i) in grades"
			        		:key="i"
			        		:value="grade"
			        	>{{grade}}</md-option>
			        </md-select>
					<span 
	      				class="md-error"
	      				v-if="form.errors.has('grade')"
	      				v-text="form.errors.get('grade')"
	      			></span>
				</md-field>

				<label>Select up to 3 tags that best describe your professor:</label>
				<br/>
				<md-chip 
					v-for="(tag, i) in tags" 
					:key="tag.id" 
					:data-id="tag.id"
    				:class="generateTagClass(tag.id)" 
    				@click="toggleTag"
    				style="margin-top: 1em"
    			>{{tag.value}}</md-chip>

				<md-field :class="{'md-invalid': form.errors.has('comment')}">
			      	<label>Write your review:</label>
			     	<md-textarea 
			     		v-model="form.comment"
			     		placeholder="Start typing your comment of your professor here. (You can press ENTER to go to the next line)."
			     		:maxlength="350"
			      		md-autogrow
			    	></md-textarea>
			    	<md-icon>description</md-icon>
			    </md-field>

			    <p>By clicking the 'Submit' button, I acknowledge that I have read and agreed to the <a href="#">Site Guidelines</a>, <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</p>

	    		<md-progress-bar v-if="awaitingResponse" md-mode="query"></md-progress-bar>
				<md-card-actions>
				<md-button :disabled="form.errors.any()" type="submit">Submit my review</md-button>
				</md-card-actions>
			</form>
		</md-card>
	</div>
</template>

<script>
	import Form from 'Js/lib/Form';
	import Fetcher from 'Js/lib/Fetcher';

	export default {
		name: 'RateProfessor',
		/**
		 * Fetch all the professors' datas
		 */
		beforeCreate() {
			Fetcher.profs(this);
		},
		/**
		 * Get the quick review from the store's state
		 */
		created() {
			const {quick} = this.$store.state.reviews;
			this.form.comment = quick;
		},
		data() {
			return {
				/**
				 * The form object for the form to rate a professor
				 * @type {Form}
				 */
				form: new Form({
					overall: 0,
					difficulty: 0,
					retake: false,
					grade: '',
					classcode: '',
					comment: '',
				}),

				/**
				 * Whether the form was submitted and we are waiting the server's response
				 * @type {Boolean}
				 */
				awaitingResponse: false,

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
			}
		},
		computed: {

			/**
			 * Determine whether the professors' datas are ready to be used
			 * @return {Boolean} 
			 */
			dataIsReady() {
				const {beingFetched, data} = this.$store.state.prof;
				return ! beingFetched && data !== null;
			},
			/**
			 * Get the professor for whom this review is being written for
			 * @return {Object|Void} 
			 */
			professor() {
				const {id} = this.$route.params;
				const {data} = this.$store.state.prof;

				if(data) {
					return data.find(prof => prof.id == id);
				}
			},

			/**
			 * Get the professor's tags to describe them
			 * @return {Array} 
			 */
			tags() {
				const tags = [
					{id: 1, value: 'Respected'},
					{id: 2, value: 'Get Ready to Read'},
					{id: 3, value: 'Lots of Homework'},
					{id: 4, value: 'Hilarious'},
					{id: 5, value: 'Test Heavy'},
				];

				return tags;
			},
		},
		watch: {
			/**
			 * When the data is ready and no professor with the given slug exists then redirect
			 * @param  {Boolean} isReady The value of the 'dataIsReady' computed property
			 * @return {Void}          
			 */
			dataIsReady: function(isReady) {
				if(isReady && !this.professor) {
					this.$router.push('/notFound');
				}
			},
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

				if(isSelected) {
					this.selectedTagsId = this.selectedTagsId.filter(tagId => tagId != id);
					return;
				}

				if(this.selectedTagsId.length < 3) {
					this.selectedTagsId.push(id);
				}
			},

			/**
			 * On keyDown, clear the errors on the target input
			 * @param  {HTMLElement} event.target The target input's HTML element
			 * @return {Void}                 
			 */
			clearFieldErrors({target}) {
				this.form.errors.clear(target.getAttribute('data-name'));
			},

			/**
			 * Handle the submitting of the form
			 * @return {Void} 
			 */
			submitForm() {
				console.log('form submitted!');
			},
		}
	}
</script>

<style scoped>
	.text-red {
		color: #ff1744;
	}
</style>