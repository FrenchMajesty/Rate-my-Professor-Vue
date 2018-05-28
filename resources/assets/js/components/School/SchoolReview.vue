<template>
	<md-card class="md-layout-item md-small-size-100 md-medium-size-95 md-size-100 space-below container" v-if="canShow" md-with-hover>
		<div class="md-layout">
			<md-content class="md-layout-item md-layout text-center md-xsmall-size-30 md-small-size-25 md-size-20">
				<div 
					class="md-layout md-layout-item md-size-80"
					style="margin-bottom: .5em"
					v-for="score in scores"
				>
					<span class="score md-layout-item md-size-30">{{score.value}}</span>{{"\b"}}
					<span class="md-layout-item md-subtitle">{{score.label}}</span> 
				</div>
			</md-content>
			<md-content class="md-layout-item">
				<p class="review-content">{{rating.comment}}</p>
				<div class="md-layout md-alignment-bottom-right">
					<ReviewFeedback 
						class="md-layout-item" 
						:itemId="rating.id"
						:positiveVotes="positiveVotes"
						:negativeVotes="negativeVotes"
						@leaveFeedback="voteOnReview"
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
	import ReviewFeedback from '../Review/ReviewFeedback';

	export default {
		name: 'SchoolReview',
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

				/**
				 * The number of positive votes
				 * @type {Number}
				 */
				positiveVotes: 0,

				/**
				 * The number of negative votes
				 * @type {Number}
				 */
				negativeVotes: 0,

				/**
				 * The list of the ratings for this review
				 * @type {Array}
				 */
				scores: [
					{label: 'Rating', value: this.rating.overall_rating},
					{label: 'Location', value: this.rating.location_rating},
					{label: 'Facilities', value: this.rating.facilities_rating},
					{label: 'Opportunity', value: this.rating.opportunity_rating},
					{label: 'Social', value: this.rating.social_rating},
				],
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
			/**
			 * Process to handle the vote on this review
			 * @param  {Boolean} positiveVote Whether value of the feedback is positive
			 * @return {Void}                
			 */
			voteOnReview(positiveVote) {
				console.log(`A user just found review (#:${this.rating.id}) ${positiveVote ? 'helpful' : 'not helpful'}.`);

				if(positiveVote) {
					this.positiveVotes++;
				}else {
					this.negativeVotes++;
				}
			},

			moment,
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
	.score {
		font-size: 1.5em;
		font-weight: bold;
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