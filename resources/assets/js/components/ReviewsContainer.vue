<template>
	<div>
		<div 
			class="md-layout-item md-size-100 md-layout"
			v-if="isReady"
		>
			<p v-if="hasRatings" class="md-layout-item md-title md-size-100">Student Reviews</p>
			<p v-else class="noreview-space"></p>
			
			<slot></slot>

			<div v-if="! hasRatings" class="md-layout md-alignment-center-center">
				<md-empty-state
					class="md-layout-item"
			      	md-icon="info_outline"
			      	md-label="No reviews for the moment"
			      	:md-description="`There seems to be no review available for this ${profileType}.. Why not be the first to write one?`">
			     	<md-button 
			     		class="md-primary md-raised"
			     		:to="buttonTarget"
			     	>Write a review</md-button>
			    </md-empty-state>
			</div>
		</div>
		<div
			class="md-layout md-alignment-center-center"
			style="margin-top: 3em" 
			v-else
		>
			<md-progress-spinner 
				:md-diameter="60"
				:md-stroke="6"
				md-mode="indeterminate"
			></md-progress-spinner>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'ReviewsContainer',
		props: {
			/**
			 * The state of readiness of the ratings
			 * @type {Object}
			 */
			isReady: {
				type: Boolean,
				required: true,
			},

			/**
			 * Whether this profile page has any ratings
			 * @type {Object}
			 */
			hasRatings: {
				type: Boolean,
				default: false,
			},

			/**
			 * The target of the `Write a Review` button in the empty state
			 * @type {Object}
			 */
			buttonTarget: {
				type: Object,
				required: true,
			},

			/**
			 * Whether the component is on a professor or school page.
			 * @type {Object}
			 */
			profileType: {
				type: String,
				required: true,
			},
		},
		data() {
			return {
				a:''
			};
		},
		computed: {
			reviewButtonTarget() {
				return;
			}
		},
		methods: {
			oo() {

			}
		},
	}
</script>