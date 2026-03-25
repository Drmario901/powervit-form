import { render } from '@react-email/render';
import * as React from 'react';
import { ContactEmail, type ContactEmailProps } from '../resources/emails/contact-email';

async function main(): Promise<void> {
    const chunks: Buffer[] = [];
    for await (const chunk of process.stdin) {
        chunks.push(chunk as Buffer);
    }
    const input = Buffer.concat(chunks).toString('utf8');
    const props = JSON.parse(input) as ContactEmailProps;
    const html = await render(<ContactEmail {...props} />);
    process.stdout.write(html);
}

main().catch((err: unknown) => {
    console.error(err);
    process.exit(1);
});
