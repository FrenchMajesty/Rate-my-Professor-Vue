<template>
	<md-card class="md-layout-item md-small-size-100 md-medium-size-95 md-size-100 space-below container" v-if="canShow" md-with-hover>
		<div class="md-layout">
			<md-content class="md-layout-item md-layout text-center md-xsmall-size-25 md-small-size-20 md-size-15">
				<div class="md-layout-item md-size-80">
					<p class="md-subtitle">Rating</p> 
					<p class="md-headline text-size3">{{rating.overall_rating}}</p>
				</div>

				<div class="md-layout-item md-size-80">
					<p class="md-subtitle">Difficulty</p> 
					<p class="md-headline text-size3">{{rating.difficulty_rating}}</p>
				</div>
			</md-content>

			<md-content class="md-layout-item md-xsmall-hide md-small-size-20 md-size-20">
				<p>Class: {{rating.class}}</p>
				<br>
				<p class="no-margin"><b>Texbook used:</b> {{textbookWasUsed}}</p>
				<p class="no-margin"><b>Would take again:</b> {{wouldRetakeClass}}</p>
				<p class="no-margin"><b>Grade Received:</b> {{rating.grade_received}}</p>
			</md-content>
			<md-content class="md-layout-item">
				<p class="review-content">{{rating.comment}}</p>
				<div class="md-layout md-alignment-bottom-right">
					<ReviewFeedback 
						class="md-layout-item" 
						:itemId="rating.id"
						:feedback="rating.feedback"
						reviewType="professor"
						@change="updateFeedback"
					></ReviewFeedback>
				</div>
			</md-content>
		</div>
		<div class="md-layout md-alignment-top-right">
			<span class="date"><md-icon>access_time</md-icon> {{moment(rating.created_at).format("MMMM Do YYYY, h:mmA")}}</span>
			<a class="md-layout-item report-link" href="#">Report this rating</a>
		</div>
	</md-card>
</template>

<script>
	import moment from 'moment';
	import ReviewFeedback from './Review/ReviewFeedback';

	export default {
		name: 'ProfessorReview',
		components: {
			ReviewFeedback,
		},
		props: {
			/**
			 * The rating model
			 * @type {Object}
			 */
			rating: {
				type: Object,
				required: true,
			},

			/**
			 * The number of ms to delay to rendering of this review
			 * @type {Number}
			 */
			delay: {
				type: Number,
				default: null,
			},
		},

		/**
		 * Determine whether to delay the rending of the component or not
		 */
		created() {
			if(this.delay) {
				setTimeout(() => this.canShow = true, this.delay);
			}else {
				this.canShow = true;
			}
		},
		data() {
			return {
				/**
				 * Whether the component is allowed to be shown
				 * @type {Boolean}
				 */
				canShow: false,
			};
		},
		computed: {
			/**
			 * Determine the textbook value of the review
			 * @return {String} 
			 */
			textbookWasUsed() {
				return this.rating.textbook_used ? 'Yes' : 'No';
			},

			/**
			 * Determine the 'would retake' value of the review
			 * @return {String} 
			 */
			wouldRetakeClass() {
				return this.rating.would_retake ? 'Yes' : 'No';
			},
		},
		methods: {
			moment,

			/**
			 * Replace the feedback on this review to update it
			 * @param  {Array} data The new feedback datas to replace
			 * @return {Void}      
			 */
			updateFeedback(data) {
				this.$store.commit({
					type: 'updateVotesOnProfessorReview',
					id: this.rating.id,
					data,
				});
			}
		},
	};
</script>

<style scoped>
	.md-subtitle {
		margin: 0;
	}
	.score-column {
		min-height: 11em;
		padding-top: 1em;
	}
	.space-below {
		margin-bottom: 1.8em;
	}
	.container {
		padding-top: 2em;
		padding-bottom: 1em;
	}
	.text-size3 {
		font-size: 2.8em;
	}
	.report-link {
		text-align: right;
	}
	.date {
		font-size: .8em;
		opacity: .4;
	}
	.review-content {
		display: block;
		height: 65%;
	}
</style>