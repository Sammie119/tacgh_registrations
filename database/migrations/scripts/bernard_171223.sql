SELECT r.id,r.reg_id,r.surname,r.firstname,l.FullName,cf.fee_tag,cf.fee_amount,max(op.payment_mode),sum(op.amount_paid)
FROM `registrants` r
         left join camp_fees cf on cf.id = r.campfee_id
         left join lookups l on l.id = r.campercat_id
         left join online_payments op on op.reg_id = r.reg_id
where confirmedpayment = 1 and op.approved = 1
GROUP by r.reg_id,r.batch_no,op.payment_mode;