#!/bin/sh

LIVE_1="i-cf9f8871"
LIVE_2="i-c89f8876"
LIVE_DB="i-93c70322"

#configure load balancers
echo "registering $LIVE_DB to jesusmarket2 load balancer:"
su - ec2-user -c "aws elb register-instances-with-load-balancer --load-balancer-name jesusmarket2 --instances $LIVE_DB"
echo ""
sleep 10

echo "registering $LIVE_DB to jesusmarket load balancer:"
su - ec2-user -c "aws elb register-instances-with-load-balancer --load-balancer-name jesusmarket --instances $LIVE_DB"
echo ""
sleep 10

echo "removing $LIVE_1 and $LIVE_2 from jesusmarket2 load balancer:"
su - ec2-user -c "aws elb deregister-instances-from-load-balancer --load-balancer-name jesusmarket2 --instances $LIVE_1 $LIVE_2"

echo ""
echo "removing $LIVE_1 and $LIVE_2 from jesusmarket load balancer:"
su - ec2-user -c "aws elb deregister-instances-from-load-balancer --load-balancer-name jesusmarket --instances $LIVE_1 $LIVE_2"
echo ""


#stopping amazon ec2 power VMs
echo "stopping amazon ec2 instances $LIVE_1 and $LIVE_2"
su - ec2-user -c "aws ec2 stop-instances --instance-ids $LIVE_1 $LIVE_2"

#checking status function
checkStatus() {

    max="5"
    alive="0"
    tries="1"
    while [ $alive -eq "0" ]
    do
        STATE=$(su - ec2-user -c "aws ec2 describe-instances --instance-ids $1 --query 'Reservations[0].Instances[0].State.Code'")

        if [ $STATE == "80" ];
        then
            alive="1"
        else
            alive="0"
            tries=$[$tries+1]
            sleep 10
        fi

        if [ $tries -ge $max ];
        then
            echo "Cannot shutdown instances... failed"
            exit 1
        fi

    done

}

#check status for $LIVE_1
checkStatus $LIVE_1
#check status for $LIVE_2
checkStatus $LIVE_2

echo ""
echo "EC2 Instances Shutdown Successful!"

exit 0
