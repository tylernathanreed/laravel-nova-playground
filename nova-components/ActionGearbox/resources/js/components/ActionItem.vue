<template>
	<component
		v-if="available"
		:is="action.to ? 'router-link' : 'div'"
		class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg"
		:data-testid="action.dusk ? `${testId}-${action.dusk}-button` : null"
		:dusk="action.dusk ? `${resource['id'].value}-${action.dusk}-button` : null"
		:to="routerLinkTo"
		:title="__(action.name)"
		@click="onActionSelected"
	>
		<icon
			:type="icon.type"
			class="mr-3"
			:width="icon.width"
			:height="icon.height"
			:view-box="icon.viewBox"
		/>
		<div>{{ __(action.name) }}</div>
	</component>
</template>

<script>
export default {

	props: [
		'testId',
		'action',
		'resource',
		'resourceName',
		'pivotName',
		'relationshipType',
		'viaRelationship',
		'viaResource',
		'viaResourceId',
		'viaManyToMany'
	],

    methods: {

    	/**
    	 * Replaces all of the wildcards in the specified value.
    	 *
    	 * @param  {Object|Array|string|null}  value
    	 *
    	 * @return {Object|Array|string|null}
    	 */
    	replaceWildcardsRecursive: function(value) {

    		// Keep nulls as-is
    		if(value === null) {
    			return null;
    		}

    		// Keep undefined as-is
    		if(value === undefined) {
    			return undefined;
    		}

    		// If the value is a string, just use standard replacement
    		if(typeof value === 'string') {
    			return this.replaceWildcards(value);
    		}

    		// If the value is an array, replace each element
    		if(Array.isArray(value)) {
    			return value.map((v) => this.replaceWildcardsRecursive(v));
    		}

    		// If the value is an object, replace each paired value
    		if(typeof value === 'object') {
    			return _.tap(value, () => Object.keys(value).map((k, v) => value[k] = this.replaceWildcardsRecursive(value[k])));
    		}

    		// Unknown value type
    		return value;

    	},

    	/**
    	 * Replaces the wildcards in the specified string.
    	 *
    	 * @param  {string}  str
    	 *
    	 * @return {string}
    	 */
    	replaceWildcards: function(str) {

    		return this.replaceAll(str, {
    			'{{resourceId}}': this.resource['id'].value,
    			'{{resourceName}}': this.resourceName,
    			'{{viaRelationship}}': this.viaRelationship,
    			'{{viaResource}}': this.viaResource,
    			'{{viaResourceId}}': this.viaResourceId
    		});

    	},

    	/**
    	 * Performs string replacement using the specified mapping.
    	 *
    	 * @param  {string}  str
    	 * @param  {object}  mapping
    	 *
    	 * @return {string}
    	 */
    	replaceAll(str, mapping) {

    		// Determine the regex
    		var regex = new RegExp(Object.keys(mapping).join('|'), 'g');

    		// Perform the replacement
    		return str.replace(regex, function(matched) {
    			return mapping[matched];
    		});

    	},

    	/**
    	 * Propagates the action selected event.
    	 *
    	 * @return void
    	 */
    	onActionSelected: function() {

    		// Don't propagate on router links
    		if(this.action.to) {
    			return;
    		}

    		// Propagate the event
    		this.$emit('onActionSelected', this.action, this.action.isPivotAction);

    	}

    },

    computed: {

        available: function() {

            // Check if the action is available for an individual resource
            if(this.action.availableForIndividualResource) {

                // We must have been given a resource
                if(this.resource) {

                    // The resource must authorize the action
                    if(this.resource.authorizedToSee[this.action.uriKey]) {
                        return true;
                    }

                }

            }

            // Check if the action is available for multiple resources
            if(this.action.availableForMultipleResources) {

                // We must have not been given a resource
                if(!this.resource) {
                    return true;
                }

            }

            // Not available
            return false;

        },

    	routerLinkTo: function() {
    		return this.replaceWildcardsRecursive(this.action.to);
    	},

    	icon: function() {

    		// Determine the icon size
    		var width = Array.isArray(this.action.iconSize) ? this.action.iconSize[0] : 20;
    		var height = Array.isArray(this.action.iconSize) ? this.action.iconSize[1] : 20;

    		// Determine the icon box size
    		var boxXOffset = Array.isArray(this.action.iconBox) ? this.action.iconBox[0] : 0;
    		var boxYOffset = Array.isArray(this.action.iconBox) ? this.action.iconBox[1] : 0;
    		var boxWidth = Array.isArray(this.action.iconBox) ? this.action.iconBox[2] : width;
    		var boxHeight = Array.isArray(this.action.iconBox) ? this.action.iconBox[3] : height;

    		// Return the icon
    		return {
    			type: this.action.icon || 'play',
    			width: width,
    			height: height,
    			viewBox: [boxXOffset, boxYOffset, boxWidth, boxHeight].join(' ')
    		};

    	}
    }

}
</script>