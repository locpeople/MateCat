<?php
/**
 * Created by PhpStorm.
 * User: fregini
 * Date: 13/02/2017
 * Time: 15:01
 */

namespace API\V2\Json;


use Teams\MembershipStruct;
use Users\MetadataStruct;

class Membership {

    protected $data;

    public function __construct( $data ) {
        $this->data = $data;
    }

    public function renderItem( MembershipStruct $membership ) {
        $out = array(
                'id'      => (int)$membership->id,
                'id_team' => (int)$membership->id_team,
        );

        if ( !is_null( $membership->getUser() ) ) {
            $out[ 'user' ] = User::renderItem( $membership->getUser() );
        }

        $metadata = UserMetadata::renderMetadataCollection( $membership->getUserMetadata() );
        if ( !empty( $metadata ) ) {
            $out[ 'user_metadata' ] = array_filter( $metadata );
        }

        $out[ 'projects' ] = (int)$membership->getAssignedProjects();

        return $out;
    }

    public function render() {
        $out = [];
        foreach ( $this->data as $membership ) {
            $out[] = $this->renderItem( $membership );
        }

        return $out;
    }


}