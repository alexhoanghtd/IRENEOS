<?php

/**
 * Controller that control products in the system
 * @author alexhoang <alexhoang.htd@gmail.com>
 * @created 23 Nov 2013
 * @copyright &copy; 2013 Creative Team 
 */
class BillController extends CTController {

    public function actionView($billID) {
        if ($bill = new Bill($billID)) {
            $billDetail = new BillDetail();
            $billDetail->setVal('bill_id', $billID);
            $billDetails = $billDetail->select();

            $this->render('view', array(
                "billdata" => $bill->getData(),
                "billDetails" => $billDetails,
            ));
        } else {
            echo "bill Id doesn't exist";
        }

        //$this->render('view', '');
    }

    public function actionList($page) {
        if (!empty($page)) {
            $model = new Bill();
            $data = $model->getBillList($page);
            $this->render('list', $data);
        } else {
            header("Location: http://irene.local/Bill/List/1");
        }
    }

}