<?php

namespace Galoa\ExerciciosPhp\TextWrap;

/**
 * Implemente sua resolução aqui.
 */

class Resolucao implements TextWrapInterface {

  /**
   * {@inheritdoc}
   */
	public function textWrap(string $text, int $length): array
  	{
  		$retArray = [];

		if (empty($text))
	    {
	  		$retArray[0] = NULL;
	    	return $retArray;
	    }

		$index = -1;        //index that represents which character in the text is the current one
		$wordIndex = 0;     //index to the word array
		$lineIndex = 0;     //index to the line array
		$end = false;
		$needToCreateWordArray = true;	//represents if it's necessary to create another word array (if it's true,
										//it's the beggining of the function or we've just ended a word)

		$howManyLinesYet = 0;			//indicates how many lines of text have been written yet


		while ($end == false)			//while the text received in the function is not over yet, we keep going
		{
			$lineArray = [];
			$lineIndex = 0;

			for ($i = 0; $i < $length; $i++)		//here we implement a for that will fill the curent line
			{
				$index++;

				if ($index == strlen($text))    //if the index represents the length of the received text
				{
				    for ($j = 0; $j < sizeof($wordArray); $j++)		//we copy the word array to the line array
					{
						$lineArray[$lineIndex] = $wordArray[$j];
						$lineIndex++;
					}

					$end = true;		//then, we set $end to true to indicates to the program it should stop
					$i = $length;		//and end this for
				}
				else
				{
					$currentCharacter = substr($text, $index, 1);	//$currentCharacter represents the character from the current position of the text

					if ($needToCreateWordArray == true)		//we create a new word array if we need to
					{
					    $wordIndex = 0;
						$wordArray = [];
						$needToCreateWordArray = false;
					}

					if ($currentCharacter == " ")						//if the current character is a space, it indicates the word has ended
					{
						for ($j = 0; $j < count($wordArray); $j++)		//so we copy the word array to the line array
						{
						    $i++;
							$lineArray[$lineIndex] = $wordArray[$j];
							$lineIndex++;
						}

						$lineArray[$lineIndex] = " ";								//copy the space to the line array
					    $lineIndex++;
						unset($wordArray);								//and unset the word array, so it can be recreated to the next word
						$needToCreateWordArray = true;
					}
					else											//if the current character is not a space
					{
						if ($i == ($length - 1))		//we verify if this is the last position of the line
						{
							$wordArray[$wordIndex] = $currentCharacter;     //we copy this last character to the word array
							$wordIndex++;

							$auxArray = [];

							for ($r = 0; $r < count($wordArray); $r++)
							    $auxArray[$r] = $wordArray[$r];



							$auxIndex = $wordIndex;

							for ($p = $index; $p < strlen($text); $p++)
							{
							    $auxCharacter = substr($text, $p, 1);

							    if ($auxCharacter != " ")
							    {
							        $auxArray[$auxIndex] = $auxCharacter;
							        $auxIndex++;
							    }
							    else
							        $p = strlen($text);
							}

							if (count($auxArray) > $length)
							{
							    for ($l = 0; $l < count($wordArray); $l++)		//copy the word until now to the line
							    {
								    $lineArray[$lineIndex] = $wordArray[$l];
								    $lineIndex++;
							    }

							    unset($wordArray);								//and prepare to create a new word array
							    $needToCreateWordArray = true;          //splitting one word in two (one half in one line, and the other half in the next line)
						    }
					    }
					    else            //else, we just copy the current character to the word array
					    {
					  	    $wordArray[$wordIndex] = $currentCharacter;
						    $wordIndex++;
					    }
				    }
			    }
		    }

		    //in the end of the for, we copy the line array to the return array
		    $retArray[$howManyLinesYet] = $lineArray;
		    unset($lineArray);                  //and unset the line array, so we can create another one to the next line
		    $howManyLinesYet += 1;		//then, we increments the number of lines
		 }

	    return $retArray;           //and return the return array
	}
}