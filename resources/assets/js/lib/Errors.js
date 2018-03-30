export default class Errors {

	/**
	 * Object constructor
	 */
	constructor() {
		this.errors = {};
	}

	/**
	 * Save the laravel server errors to the object
	 * @param  {Object} errors The validation errors
	 * @return {Void}        
	 */
	record(errors) {
		this.errors = errors;
	}

	/**
	 * Return the error message for the given field
	 * @param  {String} field Name of the field
	 * @return {String|Void}       The error message if there is one
	 */
	get(field) {
		if(this.errors[field]) {
			return this.errors[field][0];
		}
	}

	/**
	 * Evaluate whether the given field has an error
	 * @param  {String}  field Name of the field
	 * @return {Boolean}       
	 */
	has(field) {
		return this.errors.hasOwnProperty(field);
	}

	/**
	 * Delete the error message for a field entry or the entire form
	 * @param  {String} field Name of the field
	 * @return {Void}       
	 */
	clear(field) {
		if(field) {
			delete this.errors[field];
		}else {
			this.errors = {};
		}
	}
	
	/**
	 * Check if there is any errors in the object
	 * @return {Boolean} 
	 */
	any() {
		return Object.keys(this.errors).length > 0;
	}
}