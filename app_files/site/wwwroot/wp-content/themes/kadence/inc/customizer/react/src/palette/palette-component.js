import PropTypes from 'prop-types';
const { __ } = wp.i18n;
const { Component } = wp.element;
import map from 'lodash/map';
import ColorControl from '../common/color.js';
import { Fragment } from 'react';
const { ButtonGroup, Dashicon, Tooltip, Button } = wp.components;
class ColorComponent extends Component {
	constructor(props) {
		super( props );
		this.handleChangeComplete = this.handleChangeComplete.bind( this );
		this.handleChangePalette = this.handleChangePalette.bind( this );
		this.updateValues = this.updateValues.bind( this );
		let value = JSON.parse( this.props.control.setting.get() );
		let baseDefault =  ( kadenceCustomizerControlsData.palette ? JSON.parse( kadenceCustomizerControlsData.palette ) : { palette: [] } );
		this.defaultValue = this.props.control.params.default ? {
			...baseDefault,
			...this.props.control.params.default
		} : baseDefault;
		value = value ? {
			...this.defaultValue,
			...value
		} : this.defaultValue;
		let defaultParams = {
			reset: '{"palette":[{"color":"#3182CE","slug":"palette1","name":"Palette Color 1"},{"color":"#2B6CB0","slug":"palette2","name":"Palette Color 2"},{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},{"color":"#718096","slug":"palette6","name":"Palette Color 6"},{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},{"color":"#FFFFFF","slug":"palette9","name":"Palette Color 9"}],"second-palette":[{"color":"#3182CE","slug":"palette1","name":"Palette Color 1"},{"color":"#2B6CB0","slug":"palette2","name":"Palette Color 2"},{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},{"color":"#718096","slug":"palette6","name":"Palette Color 6"},{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},{"color":"#FFFFFF","slug":"palette9","name":"Palette Color 9"}],"third-palette":[{"color":"#3182CE","slug":"palette1","name":"Palette Color 1"},{"color":"#2B6CB0","slug":"palette2","name":"Palette Color 2"},{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},{"color":"#718096","slug":"palette6","name":"Palette Color 6"},{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},{"color":"#FFFFFF","slug":"palette9","name":"Palette Color 9"}],"active":"palette"}',
			colors: {
				palette1: {
					tooltip: __( '1 - Accent', 'kadence' ),
					palette: false,
				},
				palette2: {
					tooltip: __( '2 - Accent - alt', 'kadence' ),
					palette: false,
				},
				palette3: {
					tooltip: __( '3 - Strongest text', 'kadence' ),
					palette: false,
				},
				palette4: {
					tooltip: __( '4 - Strong Text', 'kadence' ),
					palette: false,
				},
				palette5: {
					tooltip: __( '5 - Medium text', 'kadence' ),
					palette: false,
				},
				palette6: {
					tooltip: __( '6 - Subtle Text', 'kadence' ),
					palette: false,
				},
				palette7: {
					tooltip: __( '7 - Subtle Background', 'kadence' ),
					palette: false,
				},
				palette8: {
					tooltip: __( '8 - Lighter Background', 'kadence' ),
					palette: false,
				},
				palette9: {
					tooltip: __( '9 - White or offwhite', 'kadence' ),
					palette: false,
				},
			},
			paletteMap: {
				'palette': {
					'tooltip': __( 'Palette 1', 'kadence' ),
				},
				'second-palette': {
					'tooltip': __( 'Palette 2', 'kadence' ),
				},
				'third-palette': {
					'tooltip': __( 'Palette 3', 'kadence' ),
				}
			}
		};
		this.controlParams = this.props.control.params.input_attrs ? {
			...defaultParams,
			...this.props.control.params.input_attrs,
		} : defaultParams;
		this.state = {
			value: value,
			colorPalette: [],
			fresh: 'start',
		};
	}
	handleChangePalette( active ) {
		let value = this.state.value;
		const newItems = this.state.value[ active ].map( ( item, index ) => {
			document.documentElement.style.setProperty('--global-' + item.slug, item.color );
			return item;
		} );
		value.active  = active;
		value[active] = newItems;
		this.setState( { fresh: ( this.state.fresh !== 'start' ? 'start' : 'second' ) } );
		this.updateValues( value );
	}
	handleChangeComplete( color, isPalette, item, index ) {
		let newColor = {};
		if ( undefined !== color.rgb && undefined !== color.rgb.a && 1 !== color.rgb.a ) {
			newColor.color = 'rgba(' +  color.rgb.r + ',' +  color.rgb.g + ',' +  color.rgb.b + ',' + color.rgb.a + ')';
		} else {
			newColor.color = color.hex;
		}
		let value = this.state.value;
		const newItems = this.state.value[this.state.value.active].map( ( item, thisIndex ) => {
			if ( parseInt( index ) === parseInt( thisIndex ) ) {
				item = { ...item, ...newColor };
				document.documentElement.style.setProperty('--global-' + this.state.value[this.state.value.active][index].slug, newColor.color );
			}

			return item;
		} );
		value[this.state.value.active] = newItems;
		this.updateValues( value );
	}

	render() {
		return (
				<div className="kadence-control-field kadence-palette-control kadence-color-control">
					<div className="kadence-palette-header">
						<Tooltip text={ __( 'Reset Values', 'kadence' ) }>
							<Button
								className="reset kadence-reset"
								onClick={ () => {
									let value = this.state.value;
									const reset = JSON.parse( this.controlParams.reset );
									const newItems = this.state.value[this.state.value.active].map( ( item, thisIndex ) => {
										item = { ...item, ...reset[this.state.value.active][ thisIndex ] };
										document.documentElement.style.setProperty('--global-' + reset[this.state.value.active][ thisIndex ].slug, reset[this.state.value.active][ thisIndex ].color );						
										return item;
									} );
									value[this.state.value.active] = newItems;
									this.updateValues( value );
								} }
							>
								<Dashicon icon='image-rotate' />
							</Button>
						</Tooltip>
						{
							this.props.control.params.label &&
							<span className="customize-control-title">
								{ this.props.control.params.label }
							</span>
						}
						{
							!this.props.hideResponsive &&
							<div className="floating-controls">
								<ButtonGroup>
									{Object.keys( this.controlParams.paletteMap ).map( (palette) => {
										return (
											<Tooltip text={this.controlParams.paletteMap[palette].tooltip}>
												<Button
														isTertiary
														className={ ( palette === this.state.value.active ?
																'active-palette ' :
																'' ) + palette}
														onClick={ () => {
															this.handleChangePalette( palette );
														} }
												>
													{ this.controlParams.paletteMap[palette].tooltip }
												</Button>
											</Tooltip>
										);
									} )}
								</ButtonGroup>
							</div>
						}
					</div>
					<div className="kadence-palette-colors">
						{ 'start' === this.state.fresh && (
							<Fragment>
								{ Object.keys( this.controlParams.colors ).map( ( item, index ) => {
										return (
											<ColorControl
												key={ index }
												presetColors={ this.state.colorPalette }
												color={ ( undefined !== this.state.value[this.state.value.active][ index ] &&  this.state.value[this.state.value.active][ index ].color ?  this.state.value[this.state.value.active][ index ].color : '' ) }
												isPalette={ '' }
												usePalette={ false }
												tooltip={ ( undefined !== this.controlParams.colors[ item ].tooltip ? this.controlParams.colors[ item ].tooltip : '' ) }
												onChangeComplete={ ( color, isPalette ) => this.handleChangeComplete( color, isPalette, item, index ) }
											/>
										)
								} ) }
							</Fragment>
						) }
						{ 'start' !== this.state.fresh && (
							<Fragment>
								{ Object.keys( this.controlParams.colors ).map( ( item, index ) => {
										return (
											<ColorControl
												key={ index }
												presetColors={ this.state.colorPalette }
												color={ ( undefined !== this.state.value[this.state.value.active][ index ] &&  this.state.value[this.state.value.active][ index ].color ?  this.state.value[this.state.value.active][ index ].color : '' ) }
												isPalette={ '' }
												usePalette={ false }
												tooltip={ ( undefined !== this.controlParams.colors[ item ].tooltip ? this.controlParams.colors[ item ].tooltip : '' ) }
												onChangeComplete={ ( color, isPalette ) => this.handleChangeComplete( color, isPalette, item, index ) }
											/>
										)
								} ) }
							</Fragment>
						) }
					</div>
					{ this.props.control.params.description && (
						<span className="customize-control-description"><a href="https://docs.kadencewp.com/kadence-theme/docs/how-to-use-the-kadence-color-palette/" target="_blank">{ this.props.control.params.description }</a></span>
					) }
				</div>
		);
	}

	updateValues( value ) {
		this.setState( { value: value } );
		this.props.control.setting.set( JSON.stringify( value ) );
		kadenceCustomizerControlsData.palette = JSON.stringify( value );
	}
}

ColorComponent.propTypes = {
	control: PropTypes.object.isRequired
};

export default ColorComponent;
