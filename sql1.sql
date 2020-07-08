select * FROM `blocks`, `records_blocks`
left join records on records.id=records_blocks.record_id
where blocks.id=records_blocks.block_id

