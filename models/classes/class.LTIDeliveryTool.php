<?php
/**  
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2013 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 *               
 * 
 */

class ltiDeliveryProvider_models_classes_LTIDeliveryTool extends taoLti_models_classes_LtiTool {
	
	const TOOL_INSTANCE = 'http://www.tao.lu/Ontologies/TAOLTI.rdf#LTIToolDelivery';
	
	public function getToolResource() {
		return new core_kernel_classes_Resource(INSTANCE_LTITOOL_DELIVERY);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see taoLti_models_classes_LtiTool::getRemoteLinkClass()
	 */
	public function getRemoteLinkClass() {
		return new core_kernel_classes_Class(CLASS_LTI_DELIVERYTOOL_LINK);
	}
	
	public function getDeliveryFromLink() {
		$remoteLink = taoLti_models_classes_LtiService::singleton()->getLtiSession()->getLtiLinkResource();
		return $remoteLink->getOnePropertyValue(new core_kernel_classes_Property(PROPERTY_LINK_DELIVERY));
	}
	
	public function linkDeliveryExecution(core_kernel_classes_Resource $link, $userUri, core_kernel_classes_Resource $deliveryExecution) {
	    $class = new core_kernel_classes_Class(CLASS_LTI_DELIVERYEXECUTION_LINK);
	    $link = $class->createInstanceWithProperties(array(
	        PROPERTY_LTI_DEL_EXEC_LINK_USER => $userUri,
	        PROPERTY_LTI_DEL_EXEC_LINK_LINK => $link,
            PROPERTY_LTI_DEL_EXEC_LINK_DELIVERYEXEC => $deliveryExecution
	    ));
	    return $link instanceof core_kernel_classes_Resource;
	}
	
	public function getDeliveryExecution(core_kernel_classes_Resource $link, $userUri) {
	    
	    $returnValue = null;
	    
	    $class = new core_kernel_classes_Class(CLASS_LTI_DELIVERYEXECUTION_LINK);
	    $candidates = $class->searchInstances(array(
	    	PROPERTY_LTI_DEL_EXEC_LINK_USER => $userUri,
	        PROPERTY_LTI_DEL_EXEC_LINK_LINK => $link,
	    ), array(
	    	'like' => false
	    ));
	    if (count($candidates) > 0) {
	        if (count($candidates) > 1) {
	            throw new common_exception_InconsistentData();
	        }
	        $link = current($candidates);
	        $returnValue = $link->getOnePropertyValue(new core_kernel_classes_Property(PROPERTY_LTI_DEL_EXEC_LINK_DELIVERYEXEC)); 
	    } 
	    return $returnValue;
	}
	
}