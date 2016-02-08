<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2016-02-09
 * Time: 00:48
 */

namespace App\Services;

use App\Services\vertex;

class VertexCalculatorService {
    public function testVertex() {
        $v0 = new vertex(0);
        $v1 = new vertex(1);
        $v2 = new vertex(2);
        $v3 = new vertex(3);
        $v4 = new vertex(4);
        $v5 = new vertex(5);

        $list0 = new SplDoublyLinkedList();
        $list0->push($v1);
        $list0->push($v3);
        $list0->rewind();

        $list1 = new SplDoublyLinkedList();
        $list1->push($v0);
        $list1->push($v2);
        $list1->rewind();

        $list2 = new SplDoublyLinkedList();
        $list2->push($v1);
        $list2->push($v3);
        $list2->push($v4);
        $list2->rewind();

        $list3 = new SplDoublyLinkedList();
        $list3->push($v1);
        $list3->push($v2);
        $list3->rewind();

        $list4 = new SplDoublyLinkedList();
        $list4->push($v2);
        $list4->push($v5);
        $list4->rewind();

        $list5 = new SplDoublyLinkedList();
        $list5->push($v4);
        $list5->rewind();

        $adjacencyList = array(
            $list0,
            $list1,
            $list2,
            $list3,
            $list4,
            $list5,
        );

        calcDistances($v0, $adjacencyList);
        print_r($adjacencyList);
    }

    public function calcDistances(vertex $start, &$adjLists) {
        // define an empty queue
        $q = array();

        // push the starting vertex into the queue
        array_push($q, $start);

        // color it gray
        $start->color = 'gray';

        // mark the distance to it 0
        $start->distance = 0;

        while ($q) {
            // 1. pop from the queue
            $t = array_pop($q);

            // 2. foreach poped item find it's adjacent white vertices
            $l = $adjLists[$t->key];
            while ($l->valid()) {
                // 3. mark them gray, increment their length with one from their parent
                if ($l->current()->color == 'white') {
                    $l->current()->color = 'gray';
                    $l->current()->distance = $t->distance + 1;
                    // 4. push them to the queue
                    array_push($q, $l->current());
                }

                $l->next();
            }
        }
    }
}
