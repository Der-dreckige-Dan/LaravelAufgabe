<?php

namespace App\operation;

use ApiPlatform\Metadata\Operation\PathSegmentNameGeneratorInterface;

class GermanPathSegementNameGenerator implements PathSegmentNameGeneratorInterface {

	public function getSegmentName(string $name, bool $collection = true): string {
        dd($name);
	}
}
