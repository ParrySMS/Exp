#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>

#include <unistd.h>
#include <stdarg.h>
#include <sys/types.h>
#include <sys/ipc.h>
#include <sys/msg.h>
#include <sys/wait.h>
#include <sys/stat.h>

#define MAX_SEND_SIZE 80

struct mymsgbuf {
	long mtype;
	char mtext[MAX_SEND_SIZE];
};

void send_message(int qid, struct mymsgbuf *qbuf,long type,char *text);
void read_message(int qid, struct mymsgbuf *qbuf,long type);
void remove_queue(int qid);
void change_queue_mode(int qid,char *mode);
void usage(void);

int main(int argc ,char*argv[]) {

	key_t key;
	int msgqueue_id;
	struct mymsgbuf qbuf;

	if(argc == 1) {
		usage();
	}

	/* create uni key via ftok() */
	key = ftok(".",'m');
	//open queue
	msgqueue_id = msgget(key,IPC_CREAT|0660);
	if(msgqueue_id == -1) {
		perror("msgget");
		exit(1);
	}

	switch(tolower(argv[1][0])) {
		case 's':
			send_message(msgqueue_id,(struct mymsgbuf*)&qbuf,atol(argv[2]),argv[3]);
			break;

		case 'r':
				read_message(msgqueue_id,&qbuf,atol(argv[2]));
				break;

			case 'd':
					remove_queue(msgqueue_id);
					break;

				case 'm':
						change_queue_mode(msgqueue_id,argv[2]);
						break;

					default:
							usage();
						}
	return 0;
}

void send_message(int qid,struct mymsgbuf *qbuf,long type,char *text) {
	int len,s_res;	 
	printf("sending ...\n");
	qbuf->mtype = type;

	strcpy(qbuf->mtext,text);

	len =strlen(qbuf->mtext)+1;
	s_res =msgsnd(qid,(struct msgbuf *)qbuf,len,0);
	if(s_res ==-1) {
		perror("msgsnd");
		exit(1);
	}
	return;
}


void read_message(int qid,struct mymsgbuf *qbuf,long type) {
	printf("reading ...\n");
	qbuf->mtype = type;

	msgrcv(qid,(struct msgbuf *)qbuf,MAX_SEND_SIZE,type,0);
	printf("type:%ld , text: $s\n",qbuf->mtype,qbuf->mtext);
	return;
}

void remove_queue(int qid) {
	msgctl(qid,IPC_RMID,0);
	return;
}

void change_queue_mode(int qid,char *mode) {
	struct msqid_ds myqueue_ds;
	msgctl(qid,IPC_STAT,&myqueue_ds);
	sscanf(mode,"%ho",&myqueue_ds.msg_perm.mode);
	msgctl(qid,IPC_SET,&myqueue_ds);
	return;
}

void usage(void) {
	fprintf(stderr, "msgtool - A utility for tinkering with msg queues\n");
	fprintf(stderr, "nUSAGE: msgtool (s)end \n");
	fprintf(stderr, "      msgtool (r)ecv \n");
	fprintf(stderr, "  	   msgtool (d)elete\n");
	fprintf(stderr, "      msgtool (m)ode \n");
	exit(1);
	
}
